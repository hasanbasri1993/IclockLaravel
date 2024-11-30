<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Device;
use DB;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    // Menampilkan daftar device
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
        //$attendances = Attendance::latest('timestamp')->orderBy('id','DESC')->paginate(15);
        $attendances = DB::table('attendances')->select('id', 'sn', 'table', 'stamp', 'employee_id', 'timestamp', 'status1', 'status2', 'status3', 'status4', 'status5')->orderBy('id', 'DESC')->paginate(15);

        return view('devices.attendance', compact('attendances'));

    }

    // Menampilkan form tambah device
    public function create()
    {
        return view('devices.create');
    }

    // Menyimpan device baru ke database
    public function store(Request $request)
    {
        $device = new Device;
        $device->nama = $request->input('nama');
        $device->no_sn = $request->input('no_sn');
        $device->lokasi = $request->input('lokasi');
        $device->save();

        return redirect()->route('devices.index')->with('success', 'Device berhasil ditambahkan!');
    }

    // Menampilkan detail device
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