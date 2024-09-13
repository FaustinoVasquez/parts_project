<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    use HasFactory;

    //protected $table = 'oc.TVs';
    protected $table = 'oc.vw_BinManagerSKUs';
    protected $primaryKey = 'id';
}
