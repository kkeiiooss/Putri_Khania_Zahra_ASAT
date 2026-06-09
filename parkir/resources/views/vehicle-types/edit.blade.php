@extends('layouts.app')
@section('page-title', 'Vehicle Type')

@section('content')
<div class="card">
    <div class="card-title"><span>Vehicle Type</span> Edit Form</div>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul style="margin:0; padding-left:1.2rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('vehicle-types.update', $vehicleType) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Vehicle Type</label>
            <input type="text" class="form-control" value="{{ $vehicleType->jenis_label }}" readonly style="background:#f5f5f5;">
        </div>
        <div class="form-group">
            <label class="form-label">First Hour Charges</label>
            <input type="number" name="perjam_pertama" class="form-control" value="{{ old('perjam_pertama', $vehicleType->perjam_pertama) }}" min="0">
        </div>
        <div class="form-group">
            <label class="form-label">Next Hourly Charges</label>
            <input type="number" name="perjam_berikutnya" class="form-control" value="{{ old('perjam_berikutnya', $vehicleType->perjam_berikutnya) }}" min="0">
        </div>
        <div class="form-group">
            <label class="form-label">Max Cost Per Day</label>
            <input type="number" name="max_perhari" class="form-control" value="{{ old('max_perhari', $vehicleType->max_perhari) }}" min="0">
        </div>
        <div style="display:flex; gap:12px; margin-top:1.5rem;">
            <a href="{{ route('vehicle-types.index') }}" class="btn-secondary" style="flex:1; justify-content:center; padding:0.65rem;">CANCEL</a>
            <button type="submit" class="btn-primary" style="flex:1; justify-content:center; padding:0.65rem;">UPDATE VEHICLE TYPE</button>
        </div>
    </form>
</div>
@endsection
