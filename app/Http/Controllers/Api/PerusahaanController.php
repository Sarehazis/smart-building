<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Perusahaan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    public function index()
    {
        try {
            $data = Perusahaan::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th,
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kwh' => 'required',
            'harga_kwh' => 'required'
        ]);

        // Cek validasi jika validasi diatas gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Simpan image
        $file = $request->file('image');
        $path = $file->store('images', 'public');
        $url = Storage::url($path);

        // Buat Perusahaan 
        $perusahaan = Perusahaan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kwh' => $request->kwh,
            'harga_kwh' => $request->harga_kwh,
            'image' => $url
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil ditambahkan',
            'data' => $perusahaan
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Perusahaan::where('id', $id)
                ->with([
                    'gedung.lantai.ruangan.device.jenis_device', 'gedung.lantai.ruangan.device.history' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    },
                    'ruangan.device.jenis_device',
                    'ruangan.device.history' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    }
                ])
                ->first();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th->getMessage(),
            ];
            return response()->json($response, 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required',
                'lokasi' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'kwh' => 'required',
                'harga_kwh' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $url = null;
            if ($request->image != null) {
                $n = str_replace(' ', '-', $request->image);

                $file = $request->file('image');
                $path = $file->store('images', 'public');
                $url = Storage::url($path);
            }

            $data = Perusahaan::find($id);
            $data->nama = $request->nama;
            $data->deskripsi = $request->deskripsi;
            $data->lokasi = $request->lokasi;
            $data->image = $url;
            $data->kwh = $request->kwh;
            $data->harga_kwh = $request->harga_kwh;

            $data->save();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Perusahaan berhasil di ubah pada smart laundry',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th,
            ];
            return response()->json($response, 500);
        }
    }
}
