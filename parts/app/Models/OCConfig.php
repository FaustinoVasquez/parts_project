<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OCConfig extends Model
{
    use HasFactory;

    protected $table = 'oc.OC_Config';
    protected $primaryKey = 'id';

    protected $guarded = [];
}
