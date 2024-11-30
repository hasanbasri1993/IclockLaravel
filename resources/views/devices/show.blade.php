@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detail Device</h2>
        <form action="{{ route('devices.update', $device->id) }}" method="post" class="d-inline">
            @csrf
            @method('put')
            <p>Status: {{ \Carbon\Carbon::parse($device->online)->diffInMinutes(now()) < 2 ? 'ONLINE' : 'OFFLINE' }}</p>
            <p>Last Online: {{ $device->online }}</p>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Nomor Serial</label>
                <input type="text" class="form-control" disabled id="exampleFormControlInput1" placeholder=""
                       name="no_sn"
                       value="{{ $device->no_sn }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Name </label>
                <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="" name="nama"
                       value="{{ $device->nama }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="" name="lokasi"
                       value="{{ $device->lokasi }}">
            </div>

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
