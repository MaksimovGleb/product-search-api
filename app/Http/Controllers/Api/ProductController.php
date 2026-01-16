<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DTOs\ProductFilterDTO;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $dto = ProductFilterDTO::fromRequest($request);

        $products = $this->productService->getFilteredProducts($dto);

        return ProductResource::collection($products);
    }
}

