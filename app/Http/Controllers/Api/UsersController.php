<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
            $data = $request->user();
            try {
                $data = $request->user();
                $response = [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Data user tersedia',
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
