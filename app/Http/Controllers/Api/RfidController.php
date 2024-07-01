<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rfid;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RfidController extends Controller
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
                'users_id' => 'required|unique:users_id',
                'rfid' => 'required|unique:rfid',
            ]);

            // Cek validasi jika gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Jika validasi sukses
            $rfid = Rfid::create([
                'users_id' => $request->users_id,
                'rfid' => $request->rfid,
            ]);

            $response = [
                'success' => true,
                'message' => 'RFID berhasil dibuat',
                'data' => $rfid
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'RFID sama tidak berhasil dibuat',
            ];
            return response()->json($response, 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Rfid $rfid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rfid $rfid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rfid $rfid)
    {
        //
    }
}
