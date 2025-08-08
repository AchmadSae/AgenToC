<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroupModel extends Model
{
      protected $table = 'product_groups';

      protected $fillable = [
            'code',
            'value',
            'terms_and_policy',
            'note'
      ];
}
