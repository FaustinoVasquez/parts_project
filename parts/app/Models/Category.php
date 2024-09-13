<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $table = 'prt.PartCategories';
    protected $primaryKey = 'PartCategoryID';
    public $timestamps = false;
    protected $guarded = [];

    public function subCategory(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function kits(): HasMany
    {
        return $this->hasMany(Kit::class);
    }

}
