<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        //nampilin semua data produk dan nampilin data trbaru di atas
        return response()->json(Product::orderBy('created_at', 'desc')->get());
    }
    public function show(string $id) {
        return response()->json(Product::findOrFail($id));
    }
}
