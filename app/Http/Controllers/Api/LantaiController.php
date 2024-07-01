<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lantai;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LantaiController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required',
            ]);

            // Cek validasi jika gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Create Lantai
            $lantai = Lantai::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json([
                'message' => 'Lantai berhasil ditambahkan',
                'data' => $lantai
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Lantai tidak berhasil ditambahkan',
                'data' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lantai $lantai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lantai $lantai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lantai $lantai)
    {
        //
    }
}
