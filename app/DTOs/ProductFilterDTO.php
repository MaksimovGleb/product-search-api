<?php

namespace App\DTOs;

use Illuminate\Http\Request;

readonly class ProductFilterDTO
{
    public function __construct(
        public ?string $q,
        public ?float  $priceFrom,
        public ?float  $priceTo,
        public ?string $categoryId,
        public ?bool   $inStock,
        public ?float  $ratingFrom,
        public ?string $sort
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            q: $request->query('q'),
            priceFrom: $request->query('price_from') ? (float)$request->query('price_from') : null,
            priceTo: $request->query('price_to') ? (float)$request->query('price_to') : null,
            categoryId: $request->query('category_id'),
            inStock: $request->has('in_stock') ? filter_var($request->query('in_stock'), FILTER_VALIDATE_BOOLEAN) : null,
            ratingFrom: $request->query('rating_from') ? (float)$request->query('rating_from') : null,
            sort: $request->query('sort')
        );
    }
}
