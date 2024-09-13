<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'prt.PartSubCategories';
    protected $primaryKey = 'PartSubCategoryID';
    public $timestamps = false;
    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function kits(): HasMany
    {
        return $this->hasMany(Kit::class);
    }

}
