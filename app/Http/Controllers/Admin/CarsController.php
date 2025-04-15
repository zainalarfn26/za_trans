<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    public function index(Request $request)
    {
        $query = Cars::query();
    
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $cars = $query->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'status' => 'required|string',
            'rental_price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/cars');
            $data['image'] = Storage::url($imagePath);
        }

        Cars::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $car = Cars::findOrFail($id);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'status' => 'required|string',
            'rental_price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($car->image) {
                $oldImagePath = str_replace('/storage', 'public', $car->image);
                Storage::delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('public/cars');
            $data['image'] = Storage::url($imagePath);
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $car = Cars::findOrFail($id);
        
        // Hapus gambar terkait jika ada
        if ($car->image) {
            $imagePath = str_replace('/storage', 'public', $car->image);
            Storage::delete($imagePath);
        }
        
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus!');
    }

}