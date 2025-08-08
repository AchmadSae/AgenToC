<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';

    protected $fillable = [
          'product_group_code',
          'product_code',
          'product_name',
          'price',
          'product_description',
          'product_image',
    ];

    public function productGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
          return $this->belongsTo(ProductGroupModel::class, 'product_group_code', 'code');
    }
}
