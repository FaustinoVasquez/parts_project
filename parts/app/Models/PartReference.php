<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartReference extends Model
{
    use HasFactory;

    protected $table = 'prt.PartReferences';
    protected $primaryKey = 'PartID';
    public $timestamps = false;
    protected $guarded = [];

    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class,'KitID','KitID');
    }

}


