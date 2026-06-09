@extends('layouts.app')
@section('page-title', 'Add Location')

@section('content')

<div style="max-width:560px;">
    <div class="card">
        <div class="card-title">Location Input Form</div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('locations.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Location Name</label>
                <input type="text" name="location_name" class="form-control"
                       value="{{ old('location_name') }}" placeholder="e.g. Gedung A">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Motorcycle</label>
                    <input type="number" name="max_motorcycle" class="form-control"
                           value="{{ old('max_motorcycle', 0) }}" min="0">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Car</label>
                    <input type="number" name="max_car" class="form-control"
                           value="{{ old('max_car', 0) }}" min="0">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Other</label>
                    <input type="number" name="max_other" class="form-control"
                           value="{{ old('max_other', 0) }}" min="0">
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:1.75rem;">
                <a href="{{ route('locations.index') }}" class="btn-outline"
                   style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn-primary"
                        style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-save"></i> Save Location
                </button>
            </div>
        </form>
    </div>
</div>

@endsection