<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GedungController extends Controller
{
    public function index()
    {
        try {
            $data = Gedung::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data gedung tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data gedung tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_gedung' => 'required|string|max:255|unique:gedung',
                'deskripsi' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $gedung = new Gedung();
            $gedung->nama_gedung = $request->nama_gedung;
            $gedung->deskripsi = $request->deskripsi;
            $gedung->save();

            return response()->json(['message' => 'Gedung Berhasil Ditambahkan', 'data' => $gedung], 201);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gedung tidak berhasil ditambahkan',
            ];
        }
    }
}
