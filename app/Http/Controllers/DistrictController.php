<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = District::query()
            ->when($request->name, fn ($q, $name) =>
                $q->where('name', 'LIKE', "%$name%")    
            )
            ->when($request->province_code, fn($q) => 
                $q->where('province_code', $request->province_code)
            )
            ->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ],Response::HTTP_OK);
    }

    public function getByProvince(string $provinceCode,Request $request)
    {
        $data = District::query()   
            ->when($request->name, fn ($q, $name) =>
                $q->where('name', 'LIKE', "%$name%")    
            )
            ->where('province_code', $provinceCode)
            ->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ],Response::HTTP_OK);
    }   
    public function hotels(District $district)
    {
        $data = $district->hotels()->latest()->get(); 
        return response()->json([
            'status' => true,
            'data' => $data
        ],Response::HTTP_OK);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        //
    }
}
