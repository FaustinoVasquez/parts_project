<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OCData extends Model
{
    use HasFactory;

    protected $table = 'oc.vw_OC_ConfigData';
    protected $primaryKey = 'tv_id';
    protected $guarded = [];

    protected $dates = [
        'created_at'
    ];

    public function oc_manufacturers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OCManufacturer::class, 'oc_manufacturer_id','id');
    }
}
