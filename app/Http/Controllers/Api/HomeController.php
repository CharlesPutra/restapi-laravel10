<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        //nampilin semua data produk dan nampilin data trbaru di atas
        $data = Product::with('category')->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }
    public function show(string $id) {
        return response()->json(Product::findOrFail($id));
    }
}
