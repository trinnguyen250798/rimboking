<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Province::query()
            ->when($request->name, fn ($q, $name) =>
                $q->where('name', 'LIKE', "%$name%")    
            )
            ->when($request->country_code, fn($q) => 
                $q->where('country_code', $request->country_code)
            )
            ->paginate(25);
    }

    public function getByCountry(string $countryCode,Request $request)
    {
        return Province::query()
            ->when($request->name, fn ($q, $name) =>
                $q->where('name', 'LIKE', "%$name%")    
            )
            ->where('country_code', $countryCode)
            ->paginate(25);
    }
    public function hotels(Province $province)
    {
        return $province->hotels()->latest()->paginate(25);
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
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }
}
