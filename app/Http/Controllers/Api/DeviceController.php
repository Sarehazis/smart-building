<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AksesRoles;
use App\Models\Device;
use App\Models\History;
use App\Models\Perusahaan;
use App\Models\Rfid;
use App\Models\SettingRoles;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function index()
    {
        try {
            $data = Device::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_device' => 'required|string|max:255',
            'jenis_device_id' => 'required',
            'mac_address' => 'required|unique:device,mac_address',
        ]);

        // Cek validasi jika validasi diatas gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create Device
        $device = Device::create([
            'nama_device' => $request->nama_device,
            'jenis_device_id' => $request->jenis_device_id,
            'mac_address' => $request->mac_address,
            'ruangan_id' => $request->ruangan_id
        ]);

        $d = Device::find($device->id);
        $d->url = '/device/' .  $device->id;
        $d->save();

        return response()->json([
            'message' => 'Device created successfully',
            'data' => $d,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Device::find($id);
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Device tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_device' => 'required|string|max:255',
            'jenis_device_id' => 'required',
            'mac_address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update Device
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update([
            'nama_device' => $request->nama_device,
            'jenis_device_id' => $request->jenis_device_id,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'message' => 'Device berhasil diupdate',
            'data' => $device,
        ], 200);
    }

    // Update suhu
    public function updateSuhu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'suhu' => 'required|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update(['suhu' => $request->suhu]);

        return response()->json([
            'message' => 'Suhu berhasil diupdate',
            'data' => $device,
        ], 200);
    }

    // Update status
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|nullable',
            'perusahaan_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update(['status' => $request->status]);
        $device->save();

        // Find last device_id
        $lastDevice = History::where('device_id', $device->id)->latest()->first();

        $time = 0;
        $harga = 0;


        // Check if there is a previous record
        if (!$lastDevice) {
            $time = 0;
        } else {
            $time = $lastDevice->created_at->diffInMinutes(Carbon::now());

            $hargaMenit  = $device->watt / 1000 / 60 * $time;
            // Ambil data perusahaan
            $perusahaan = Perusahaan::find($request->perusahaan_id);

            $harga = $hargaMenit * $perusahaan->harga_kwh;
        }

        // History
        $history = History::create([
            'users_id' => auth()->user()->id,
            'device_id' => $device->id,
            'status' => $request->status,
            'waktu' => $time,
            'harga' => $harga
        ]);

        return response()->json([
            'message' => 'Status berhasil diupdate',
            'time' => $time,
            'harga_menit' => $hargaMenit,
            'harga' => $harga,
            'data' => $device,
        ], 200);
    }


    // Update min_suhu dan max_suhu
    public function updateSuhuRange(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'min_suhu' => 'required|nullable',
            'max_suhu' => 'required|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update([
            'min_suhu' => $request->min_suhu,
            'max_suhu' => $request->max_suhu,
        ]);

        return response()->json([
            'message' => 'Min dan Max Suhu berhasil diupdate',
            'data' => $device,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        try {
            $data = Device::destroy($device->id);
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Device berhasil di hapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Device tidak berhasil di hapus',
            ];
            return response()->json($response, 500);
        }
    }

    public function getStatusLampu($macAddress)
    {
        // Cari perangkat berdasarkan MAC address
        $device = Device::where('mac_address', $macAddress)->first();

        // Jika perangkat ditemukan, kembalikan status lampu
        if ($device) {
            return response()->json($device->status);
        }

        // Jika perangkat tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Device not found'], 404);
    }

    public function cekRfid(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'mac_address' => 'required|string'
        ]);

        $uid = $request->input('uid');

        // Pengecekan Rfid
        $rfid = Rfid::where('rfid', $uid)->first();
        if ($rfid == null) {
            return response()->json(['message' => 'Rfid tidak ditemukan'], 404);
        }

        // Pengecekan User
        $user = User::find($rfid->users_id);
        if ($user == null) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Pengecekan Role
        $setting_roles = SettingRoles::where('users_id', $user->id)->pluck('roles_id');
        if ($setting_roles->isEmpty()) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        // Pengecekan Device
        $device = Device::where('mac_address', $request->mac_address)->first();
        if ($device == null) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        // Pengecekan Akses
        $akses = AksesRoles::whereIn('roles_id', $setting_roles)
            ->where('ruangan_id', $device->ruangan_id)
            ->first();

        if (!$akses) {
            return response()->json([
                'message' => 'Akses tidak diterima',
                'akses_data' => 'Tidak ada akses yang ditemukan untuk ruangan ini'
            ], 403);
        }

        // Membuat History
        $history = History::create([
            'users_id' => $user->id,
            'device_id' => $device->id,
            'status' => 1,
            'waktu' => 0,
            'harga' => 0,
        ]);

        return response()->json([
            'message' => 'Akses diterima',
            'akses_data' => $akses
        ]);
    }

    public function updateRuangan(Request $request, $id)
    {
        try {

            $device = Device::find($id);
            $device->update(['ruangan_id' => $request->ruangan_id]);
            $device->save();
            return response()->json([
                'message' => 'Ruangan berhasil diupdate',
                'data' => $device,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ruangan gagal diupdate'], 500);
        }
    }

    public function getMacAddress(Request $macAddress)
    {
        $device = Device::where('mac_address', $macAddress->mac_address)->with('jenis_device')->first();
        $response = [
            'success' => true,
            'data' => $device,
            'message' => 'Data Mac Address tersedia',
        ];
        return response()->json($response, 200);
    }
}
