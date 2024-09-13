<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCConfigList extends Model
{
    use HasFactory;

    protected $table = 'oc.vw_OC_ConfigList';
    protected $primaryKey = 'tv_id';
    protected $guarded = [];

    protected $dates = [
        'created_at'
    ];
}
