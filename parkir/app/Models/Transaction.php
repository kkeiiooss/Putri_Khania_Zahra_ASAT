<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $table = 'parkir_transactions';

    protected $fillable = [
        'id_lokasi',
        'no_tiket',
        'no_polisi',
        'id_jenis',
        'masuk',
        'keluar',
        'perjam_pertama',
        'perjam_berikutnya',
        'max_perhari',
        'total_jam',
        'total_bayar',
    ];

    protected $casts = [
        'masuk'  => 'datetime',
        'keluar' => 'datetime',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'id_jenis');
    }

    public static function hitungBiaya(VehicleType $vt, Carbon $masuk, Carbon $keluar): array
    {
        $totalDetik = $masuk->diffInSeconds($keluar);
        $totalMenit = intdiv($totalDetik, 60); 
        $sisaDetik  = $totalDetik % 60;        
        if ($sisaDetik >= 50) {
            $totalMenit += 1; 
        }
        $totalJam = max(1, $totalMenit);

        if ($totalJam <= 24) {
            $biaya = $vt->perjam_pertama + ($vt->perjam_berikutnya * ($totalJam - 1));
            $biaya = min($biaya, $vt->max_perhari);
            $totalHari = 0;
        } else {
            $totalHari = ceil($totalJam / 24);
            $biayaPerHari = $vt->max_perhari * 0.6;
            $biaya = $totalHari * $biayaPerHari;
        }

        return [
            'total_jam'   => $totalJam,
            'total_hari'  => $totalHari ?? 0,
            'total_bayar' => (int) $biaya,
        ];
    }

    public static function generateNoTiket(Carbon $waktu): string
    {
        return $waktu->format('YmdHis') . rand(100, 999);
    }
}
