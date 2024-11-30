@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $lable }}</h2>
        <a href="{{ route('devices.create') }}" class="btn btn-primary mb-3">Tambah</a>
        <table class="table table-bordered data-table" id="devices">
            <thead>
            <tr>
                <th>No</th>
                <th>Serial Number</th>
                <th>Lokasi</th>
                <th>Online</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($log as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->no_sn }}</td>
                    <td>{{ $d->lokasi }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->online)->diffInMinutes(now()) < 2 ? 'ONLINE' : 'OFFLINE' }}</td>
                    <td><a href="{{ route('devices.edit', ["id"=> $d->id]) }}" class="btn btn-primary mb-3">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
