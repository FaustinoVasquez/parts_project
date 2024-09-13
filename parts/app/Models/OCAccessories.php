<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCAccessories extends Model
{
    use HasFactory;

    protected $table = 'oc.vw_OC_Accessories';
    protected $primaryKey = 'id';

    protected $guarded = [];
}
