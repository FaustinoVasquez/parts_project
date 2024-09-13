<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxContent extends Model
{
    use HasFactory;

    protected $table = 'bin.BoxContent';
    protected $primaryKey = 'boxcontent_id';
//    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['date_created'];
}
