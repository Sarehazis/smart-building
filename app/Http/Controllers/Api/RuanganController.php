<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function index()
    {
        try {
            $data = Ruangan::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
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
        try {
            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255|unique:ruangan',
                'deskripsi' => 'required',
                'ukuran' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create Ruangan
            $ruangan = Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
                'deskripsi' => $request->deskripsi,
                'ukuran' => $request->ukuran,
            ]);

            return response()->json(['message' => 'Ruangan Berhasil Ditambahkan', 'data' => $ruangan], 201);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Ruangan tidak berhasil ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Ruangan::find($id);
            if ($data == null) {
                $response = [
                    'success' => false,
                    'message' => 'Ruangan Tidak Ditemukan',
                ];
                return response()->json($response, 404);
            }
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data  Ruangan Tersedia =  ' . $data->nama,
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Ruangan Tidak Ditemukan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan)
    {
        //
    }
}
