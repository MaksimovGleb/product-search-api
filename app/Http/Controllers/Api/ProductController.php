<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request) {
        $query = Product::query()->with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $query->when($request->price_from, fn($q, $v) => $q->where('price', '>=', $v))
            ->when($request->price_to, fn($q, $v) => $q->where('price', '<=', $v));

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('in_stock')) {
            $query->where('in_stock', filter_var($request->in_stock, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->filled('rating_from')) {
            $query->where('rating', '>=', $request->rating_from);
        }

        match ($request->sort) {
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            'newest'      => $query->latest(),
            default       => $query->latest(),
        };

        return response()->json($query->paginate(15));
    }
}
