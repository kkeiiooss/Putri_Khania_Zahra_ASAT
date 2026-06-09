@extends('layouts.app')

@section('page-title', 'Location')

@section('topbar-search')
<form method="GET" action="{{ route('locations.index') }}" style="display:flex;">
    <div class="topbar-search">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Type here..." value="{{ $search ?? '' }}">
    </div>
</form>
@endsection

@section('topbar-actions')
<a href="{{ route('locations.create') }}" class="btn-primary">
    <i class="fas fa-plus"></i> ADD NEW LOCATION
</a>
@endsection

@section('content')
@if(session('success_location'))
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="modal-icon-success"><i class="fas fa-check"></i></div>
        <div class="modal-title">Good Job</div>
        <div class="modal-msg">{{ session('success_location') }}</div>
        <button class="btn-primary" onclick="document.getElementById('successModal').style.display='none'">OK</button>
    </div>
</div>
@endif

<div class="card">
    <div class="card-title"><span>Location</span> Data Table</div>
    <table>
        <thead>
            <tr>
                <th style="text-align:center;">NO.</th>
                <th style="text-align:center;">LOCATION NAME</th>
                <th style="text-align:center;">MAX MOTORCYCLE</th>
                <th style="text-align:center;">MAX CAR</th>
                <th style="text-align:center;">MAX TRUCK/BUS/OTHER</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($locations as $i => $loc)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}.</td>
                <td style="text-align:center;">{{ $loc->location_name }}</td>
                <td style="text-align:center;">{{ $loc->max_motorcycle }}</td>
                <td style="text-align:center;">{{ $loc->max_car }}</td>
                <td style="text-align:center;">{{ $loc->max_other }}</td>
                <td>
                    
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#aaa; padding: 2rem;">Belum ada data lokasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
