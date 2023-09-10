<?php

namespace App\Models;

use App\Http\Controllers\Admin\ProductAttributeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory;

    protected $table = "attributes";
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }

    public function values()
    {
        return $this->hasMany(ProductAttribute::class)->select('attribute_id', 'value')->distinct();
    }
    public function variationValues()
    {
        return $this->hasMany(ProductVariation::class)->select('attribute_id', 'value')->distinct();
    }
}
