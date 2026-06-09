@extends('layouts.app')
@section('page-title', 'Transaction Report')

@section('content')
<div class="card">
    <div class="card-title"><span>Transaction</span> Report</div>
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>TICKET NO.</th>
                    <th>POLICE NO.</th>
                    <th>LOCATION</th>
                    <th>VEHICLE</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th>FIRST H.</th>
                    <th>NEXT H.</th>
                    <th>MAX/DAY</th>
                    <th>TOTAL HRS</th>
                    <th>TOTAL DAYS</th>
                    <th>TOTAL PAYS</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="13" style="text-align:center;color:#aaa;padding:2rem;">Belum ada data transaksi selesai.</td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
