<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
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

        return response()->json([
            'message' => 'Status berhasil diupdate',
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
}
