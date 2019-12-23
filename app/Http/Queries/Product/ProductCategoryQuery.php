<?php


namespace App\Http\Queries\Product;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Product\ProductCategory;

class ProductCategoryQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ProductCategory::query());
        $this->allowedFilters([
                'title',
            ])
        ->defaultSort('-id');
    }

}
