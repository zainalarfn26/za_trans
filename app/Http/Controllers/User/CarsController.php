<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cars;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Cars::where('status', 'available')
        ->when($request->search, function($query) use ($request) {
            return $query->where('brand', 'like', '%'.$request->search.'%')
                        ->orWhere('model', 'like', '%'.$request->search.'%');
        })
        ->get(['id', 'brand', 'model', 'rental_price', 'image']);

    return response()->json($cars);
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
        $car = Cars::findOrFail($id, ['id', 'brand', 'model', 'rental_price', 'image']);
        return response()->json($car);
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
