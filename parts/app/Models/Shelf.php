<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $table = 'bin.Shelves';
    protected $primaryKey = 'shelf_id';
    protected $guarded = [];
    protected $dates = ['DateCreated'];


    public function boxes()
    {
        return $this->hasMany(Box::class, 'shelf_id','shelf_id');
    }


    public function getCreatedAt() {
        if($this->created_at){
            return $this->created_at->format('m/d/Y');
        }
    }
}
