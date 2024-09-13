<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSku extends Model
{
    use HasFactory;
    protected $table = 'prt.vw_MasterRefSKUList';
    protected $primaryKey = 'ref_parentid';
    protected $guarded = [];
}
