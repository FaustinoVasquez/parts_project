<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitOrderLCN extends Model
{
    use HasFactory;
    protected $table = 'ord.KitsOrderLCNs';
    protected $primaryKey = 'orderlcn_id';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
