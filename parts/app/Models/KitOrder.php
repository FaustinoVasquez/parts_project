<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitOrder extends Model
{
    use HasFactory;
    protected $table = 'ord.KitsOrder';
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'fullfilled_at'
    ];

    public function kitOrderDetails()
    {
        return $this->hasMany(KitOrderDetail::class ,'order_id', 'order_id');
    }

}
