<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Device;
use DB;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $data['lable'] = 'Devices';
        $data['log'] = DB::table('devices')->select('*')->orderBy('online', 'DESC')->get();

        return view('devices.index', $data);
    }

    public function DeviceLog(Request $request)
    {
        $data['lable'] = 'Devices Log';
        $data['log'] = DB::table('device_log')->select('id', 'data', 'url')->orderBy('id', 'DESC')->get();

        return view('devices.log', $data);
    }

    public function FingerLog(Request $request)
    {
        $data['lable'] = 'Finger Log';
        $data['log'] = DB::table('finger_log')->select('id', 'data', 'url')->orderBy('id', 'DESC')->get();

        return view('devices.log', $data);
    }

    public function Attendance()
    {
        return view('devices.attendance');
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $device = new Device;
        $device->nama = $request->input('nama');
        $device->no_sn = $request->input('no_sn');
        $device->lokasi = $request->input('lokasi');
        $device->save();

        return redirect()->route('devices.index')->with('success', 'Device berhasil ditambahkan!');
    }

    public function show($id)
    {
        $device = Device::find($id);

        return view('devices.show', compact('device'));
    }

    public function edit($id)
    {
        $device = Device::find($id);

        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::find($id);
        $device->nama = $request->input('nama');
        $device->lokasi = $request->input('lokasi');
        $device->save();

        return redirect()->route('devices.index')->with('success', 'Device berhasil diupdate!');
    }

    public function destroy($id)
    {
        $device = Device::find($id);
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device berhasil dihapus!');
    }
}
