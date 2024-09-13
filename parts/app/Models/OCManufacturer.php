<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCManufacturer extends Model
{
    use HasFactory;

    protected $table = 'oc.OC_Manufacturers';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public function oc_data(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OCData::class, 'id','oc_manufacturer_id');
    }

}
