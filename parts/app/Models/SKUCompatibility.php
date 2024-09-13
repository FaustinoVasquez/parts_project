<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKUCompatibility extends Model
{
    use HasFactory;
    protected $table = 'prt.RefSKUsCompatability';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
