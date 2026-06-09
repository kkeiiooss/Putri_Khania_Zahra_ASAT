@extends('layouts.app')
@section('page-title', 'Location Report')

@section('content')
<div class="card">
    <div class="card-title"><span>Location</span> Report</div>
    <table>
        <thead>
            <tr>
                <th>NO.</th>
                <th>LOCATION NAME</th>
                <th>MAX MOTORCYCLE</th>
                <th>MAX CAR</th>
                <th>MAX OTHER</th>
                <th>TOTAL TRANSAKSI</th>
                <th>AKTIF PARKIR</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="7" style="text-align:center;color:#aaa;padding:2rem;">Belum ada data.</td></tr>
        </tbody>
    </table>
</div>
@endsection
