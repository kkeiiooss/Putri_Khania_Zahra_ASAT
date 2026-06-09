@extends('layouts.app')
@section('page-title', 'Edit Location')

@section('content')

<div style="max-width:560px;">
    <div class="card">
        <div class="card-title">Location Edit Form</div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('locations.update', $location) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Location Name</label>
                <input type="text" name="location_name" class="form-control"
                       value="{{ old('location_name', $location->location_name) }}">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px;">
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Motorcycle</label>
                    <input type="number" name="max_motorcycle" class="form-control"
                           value="{{ old('max_motorcycle', $location->max_motorcycle) }}" min="0">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Car</label>
                    <input type="number" name="max_car" class="form-control"
                           value="{{ old('max_car', $location->max_car) }}" min="0">
                </div>
                <div class="form-group" style="margin:0;">
                    <label class="form-label">Max Other</label>
                    <input type="number" name="max_other" class="form-control"
                           value="{{ old('max_other', $location->max_other) }}" min="0">
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:1.75rem;">
                <a href="{{ route('locations.index') }}" class="btn-outline"
                   style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
                <button type="submit" class="btn-primary"
                        style="flex:1; justify-content:center; padding:0.65rem;">
                    <i class="fas fa-save"></i> Update Location
                </button>
            </div>
        </form>
    </div>
</div>

@endsection