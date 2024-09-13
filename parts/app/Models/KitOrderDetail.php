<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitOrderDetail extends Model
{
    use HasFactory;
    protected $table = 'ord.KitsOrderDetails';
    protected $primaryKey = 'orderdetail_id';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
