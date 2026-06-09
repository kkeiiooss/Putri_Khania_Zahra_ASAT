<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Transaction;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index()
    {
        $locations    = Location::orderBy('id')->get();
        $vehicleTypes = VehicleType::orderBy('id')->get();
        $tickets      = Transaction::with(['location', 'vehicleType'])
            ->orderByDesc('masuk')
            ->take(5)
            ->get();

        return view('transactions.index', compact('locations', 'vehicleTypes', 'tickets'));
    }

    public function enter(Request $request)
    {
        $request->validate([
            'id_lokasi' => 'required|exists:parkir_locations,id',
            'id_jenis'  => 'required|exists:parkir_vehicle__types,id',
        ]);

        $location    = Location::findOrFail($request->id_lokasi);
        $vehicleType = VehicleType::findOrFail($request->id_jenis);
        $masuk       = Carbon::now();
        $noTiket     = Transaction::generateNoTiket($masuk);

        $kapasitasField = match($vehicleType->jenis) {
            'motorcycle' => 'max_motorcycle',
            'car'        => 'max_car',
            'other'      => 'max_other',
        };

        $terpakai = Transaction::where('id_lokasi', $location->id)
            ->where('id_jenis', $vehicleType->id)
            ->whereNull('keluar')
            ->count();

        if ($terpakai >= $location->$kapasitasField) {
            return back()->with('error', 'Kapasitas parkir penuh untuk jenis kendaraan ini!');
        }

        $transaction = Transaction::create([
            'id_lokasi'  => $location->id,
            'no_tiket'   => $noTiket,
            'id_jenis'   => $vehicleType->id,
            'masuk'      => $masuk,
        ]);

        $this->generateTicketPdf($transaction, $location, $vehicleType);

        return redirect()->route('transactions.index')
            ->with('success_tiket', $noTiket)
            ->with('new_transaction_id', $transaction->id);
    }

    public function exit(Request $request)
    {
        $request->validate([
            'no_tiket'  => 'required|string',
            'no_polisi' => 'required|string|max:15',
        ]);

        $transaction = Transaction::with('vehicleType')
            ->where('no_tiket', $request->no_tiket)
            ->whereNull('keluar')
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Tiket tidak ditemukan atau kendaraan sudah keluar!');
        }

        $keluar = Carbon::now();
        $vt     = $transaction->vehicleType;
        $hasil  = Transaction::hitungBiaya($vt, $transaction->masuk, $keluar);

        $transaction->update([
            'no_polisi'         => $request->no_polisi,
            'keluar'            => $keluar,
            'perjam_pertama'    => $vt->perjam_pertama,
            'perjam_berikutnya' => $vt->perjam_berikutnya,
            'max_perhari'       => $vt->max_perhari,
            'total_jam'         => $hasil['total_jam'],
            'total_bayar'       => $hasil['total_bayar'],
        ]);

        $this->generateTicketPdf($transaction->fresh(['location', 'vehicleType']), $transaction->location, $vt);

        return redirect()->route('transactions.index')
            ->with('total_bayar', $hasil['total_bayar'])
            ->with('exited_ticket', $request->no_tiket);
    }

    public function getTicket($noTiket)
    {
        $transaction = Transaction::where('no_tiket', $noTiket)
            ->whereNull('keluar')
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Tiket tidak valid'], 404);
        }

        return response()->json(['no_tiket' => $transaction->no_tiket]);
    }

     
    public function viewAll()
    {
        $transactions = Transaction::with(['location', 'vehicleType'])
            ->orderByDesc('masuk')
            ->get();

        return view('transactions.all', compact('transactions'));
    }

    public function showTicket($noTiket)
    {
        $path = storage_path("app/public/tickets/{$noTiket}.pdf");

        if (!file_exists($path)) {
            abort(404, 'Tiket tidak ditemukan');
        }

        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }

    private function generateTicketPdf(Transaction $transaction, Location $location, VehicleType $vehicleType)
    {
        $jenisLabel = match($vehicleType->jenis) {
            'motorcycle' => 'Motor',
            'car'        => 'Mobil',
            'other'      => 'Truck/Bus/Lainnya',
            default      => ucfirst($vehicleType->jenis),
        };

        $pdf = Pdf::loadView('transactions.ticket-pdf', [
            'transaction'  => $transaction,
            'location'     => $location,
            'vehicleType'  => $vehicleType,
            'jenisLabel'   => $jenisLabel,
        ])->setPaper([0, 0, 226.77, 340.16]); 

        Storage::disk('public')->put(
            "tickets/{$transaction->no_tiket}.pdf",
            $pdf->output()
        );
    }
}
