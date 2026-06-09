@extends('layouts.app')
@section('page-title', 'Vehicle Type')

@section('topbar-search')
<form method="GET" action="{{ route('vehicle-types.index') }}" style="display:flex;">
    <div class="topbar-search">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="Search vehicle type..." value="{{ $search ?? '' }}">
    </div>
</form>
@endsection

@section('topbar-actions')
<a href="{{ route('vehicle-types.create') }}" class="btn-primary">
    <i class="fas fa-plus"></i> Add Vehicle Type
</a>
@endsection

@section('content')

@if(session('success_vt'))
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="modal-icon-success"><i class="fas fa-check"></i></div>
        <div class="modal-title">Good Job!</div>
        <div class="modal-msg">{{ session('success_vt') }}</div>
        <button class="btn-primary" style="justify-content:center; width:100%;"
                onclick="document.getElementById('successModal').style.display='none'">
            <i class="fas fa-check"></i> OK
        </button>
    </div>
</div>
@endif

<div class="card">
    <div class="card-title">Vehicle Type Data Table</div>
    <table>
        <thead>
            <tr>
                <th style="text-align:center;">No.</th>
                <th style="text-align:center;">Vehicle Type</th>
                <th style="text-align:center;">First Hour Charges</th>
                <th style="text-align:center;">Next Hourly Charges</th>
                <th style="text-align:center;">Max Cost Per Day</th>
                <th  style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicleTypes as $i => $vt)
            <tr>
                <td style="color:var(--text-muted); font-weight:600;">{{ $i + 1 }}</td>
                <td style="text-align:center;">
                    <span style="font-weight:700; color:var(--text-main);">{{ $vt->jenis_label }}</span>
                </td>
                <td style="text-align:center;" style="font-weight:600;">Rp {{ number_format($vt->perjam_pertama, 0, ',', '.') }}</td>
                <td style="text-align:center;"style="font-weight:600;">Rp {{ number_format($vt->perjam_berikutnya, 0, ',', '.') }}</td>
                <td style="text-align:center;">>Rp {{ number_format($vt->max_perhari, 0, ',', '.') }}</span>
                </td>
                <td style="text-align:center;">
                    <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                        <a href="{{ route('vehicle-types.edit', $vt) }}" class="btn-outline btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('vehicle-types.destroy', $vt) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Hapus vehicle type ini?')">
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:3rem; color:var(--text-muted);">
                    <i class="fas fa-car" style="font-size:28px; display:block; margin-bottom:10px; opacity:.3;"></i>
                    Belum ada data vehicle type.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection