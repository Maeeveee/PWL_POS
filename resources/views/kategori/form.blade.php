@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page_title }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ $action_url }}">
                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama ?? '') }}" required>
                    @error('nama')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url($route) }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
