<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartControl extends Model
{
    use HasFactory;
    protected $table = 'prt.vw_SmartControlLCNList';
    protected $primaryKey = 'LicensePlateNumber';
//    public $timestamps = false;
    protected $guarded = [];
}
