<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\ProductFilterDTO;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $dto = ProductFilterDTO::fromRequest($request);

        $products = $this->productService->getFilteredProducts($dto);

        return response()->json($products);
    }
}

