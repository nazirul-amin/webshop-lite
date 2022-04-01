<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function getPriceAttribute($price)
    {
        return $this->attributes['price'] = number_format($price, 2);
    }
    public function category(){
        return $this->hasOne(ProductCategory::class, 'id', 'category_id')->withTrashed();
    }
    public function subCategory(){
        return $this->hasOne(SubProductCategory::class, 'id', 'sub_category_id')->withTrashed();
    }
}
