<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        return Country::query()
            ->when($request->name, fn ($q, $name) =>
                $q->where('name', 'LIKE', "%$name%")    
            )
            ->when($request->code, fn($q) => 
                $q->where('code', $request->code)
            )
            ->when($request->slug, fn($q) => 
                $q->where('slug', $request->slug)
            )
            ->paginate(25);
    }
    public function hotels(Country $country)
    {
        return $country->hotels()->latest()->paginate(25);
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
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        //
    }
}
