<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartList extends Model
{
    use HasFactory;
    protected $table = 'prt.PartsList';
    protected $primaryKey = 'PartsListID';
    public $timestamps = false;
    protected $guarded = [];
}
