<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //nampilkan `semua data api
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //store api
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,mp4,mov|max:20480'
        ]);
        //menyimpan file
        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'file' => $path
        ]);
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //lihat data dari id atau show data api
        return response()->json(Product::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //update api
        $product = Product::findOrFail($id);
         $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,mp4,mov|max:20480'
        ]);
        //hapus file sebelumnya
        if ($request->hasFile('file')) {
            if ($product->file && Storage::disk('public')->exists($product->file)) {
                Storage::disk('public')->delete($product->file);
            };
            //menyimpan file baru
            $product->file = $request->file('file')->store('uploads', 'public');
        }
        $product->update($request->only('name','description','price'));
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        //hapus file
        if ($product->file && Storage::disk('public')->exists($product->file)) {
            Storage::disk('public')->delete($product->file);
        }
        //delete atau destroy api
        $product->delete();
        
        return response()->json(null, 204);
    }
}
