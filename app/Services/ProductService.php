<?php

namespace App\Services;

use App\DTOs\ProductFilterDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getFilteredProducts(ProductFilterDTO $dto): LengthAwarePaginator
    {
        $query = Product::query()->with('category');

        $this->applyFilters($query, $dto);
        $this->applySorting($query, $dto->sort);

        return $query->paginate(15);
    }

    private function applyFilters(Builder $query, ProductFilterDTO $dto): void
    {
        if ($dto->q) {
            $query->where('name', 'like', '%' . $dto->q . '%');
        }

        $query->when($dto->priceFrom, fn($q, $v) => $q->where('price', '>=', $v))
            ->when($dto->priceTo, fn($q, $v) => $q->where('price', '<=', $v));

        if ($dto->categoryId) {
            $query->where('category_id', $dto->categoryId);
        }

        if ($dto->inStock !== null) {
            $query->where('in_stock', $dto->inStock);
        }

        if ($dto->ratingFrom) {
            $query->where('rating', '>=', $dto->ratingFrom);
        }
    }

    private function applySorting(Builder $query, ?string $sort): void
    {
        match ($sort) {
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            'newest'      => $query->latest(),
            default       => $query->latest(),
        };
    }
}
