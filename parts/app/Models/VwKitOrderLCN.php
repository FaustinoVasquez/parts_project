<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VwKitOrderLCN extends Model
{
    use HasFactory;
    protected $table = 'ord.vw_KitOrderLCNs';
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
