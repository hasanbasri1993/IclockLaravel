@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Device</h2>
        <form action="{{ route('devices.update', $device->id) }}" method="post" class="d-inline">
            @csrf
            @method('put')
            <p>Nomor Serial: {{ $device->no_sn }}</p>
            <p>Status: {{ $device->online }}</p>
            <input type="text" class="form-text" name="nama" value="{{ $device->nama }}">
            <input type="text" class="form-text"  name="lokasi" value="{{ $device->lokasi }}">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <form action="{{ route('devices.destroy', $device->id) }}" method="post" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus device ini?')">Hapus
            </button>
        </form>
    </div>
@endsection
