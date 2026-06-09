@extends('layouts.app')
@section('page-title', 'Add Vehicle Type')

@section('content')

<div style="max-width:520px;">
    <div class="card">
        <div class="card-title">Vehicle Type Input Form</div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        @if(empty($availableJenis))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            Semua jenis kendaraan sudah ditambahkan (Motorcycle, Car, Other).
        </div>
        <a href="{{ route('vehicle-types.index') }}" class="btn-outline" style="display:inline-flex;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        @else
        <form method="POST" action="{{ route('vehicle-types.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Vehicle Type</label>
                <select name="jenis" class="form-control">
                    @foreach($availableJenis as $j)
                    <option value="{{ $j }}" {{ old('jenis') == $j ? 'selected' : '' }}>
                        {{ match($j) { 'motorcycle' => 'Motorcycle', 'car' => 'Car', 'other' => 'Truck/Bus/Other' } }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">First Hour Charges (Rp)</label>
                <input type="number" name="perjam_pertama" class="form-control"
                       value="{{ old('perjam_pertama', 2000) }}" min="0">
            </div>

            <div class="form-group">
                <label class="form-label">Next Hourly Charges (Rp)</label>
                <input type="number" name="perjam_berikutnya" class="form-control"
                       value="{{ old('perjam_berikutnya', 1000) }}" min="0">
            </div>

            <div class="form-group">
                <label class="form-label">Max Cost Per Day (Rp)</label>
                <input type="number" name="max_perhari" class="form-control"
                       value="{{ old('max_perhari', 10000) }}" min="0">
            </div>

            <div style="display:flex; gap:10px; margin-top:1.75rem;">
                <a href="{{ route('vehicle-types.index') }}" class="btn-outline"
                   style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn-primary"
                        style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-save"></i> Save Vehicle Type
                </button>
            </div>
        </form>
        @endif
    </div>
</div>

@endsection