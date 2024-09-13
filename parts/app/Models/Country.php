<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    protected $table = 'prt.Countries';
    protected $primaryKey = 'CountryID';
    public $timestamps = false;
    protected $guarded = [];

    public function kits(): HasMany
    {
        return $this->hasMany(Kit::class);
    }

}
