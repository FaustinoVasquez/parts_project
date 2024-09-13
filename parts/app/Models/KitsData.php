<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KitsData extends Model
{
    use HasFactory;
    protected $table = 'prt.vw_PartsKitData';
    protected $primaryKey = 'KitID';
    protected $guarded = [];

    protected $dates = [
        'DateManufactured',
        'created_at'
    ];

//    public function category(): BelongsTo
//    {
//        return $this->belongsTo(Category::class,'PartCategoryID','PartCategoryID');
//    }
//
//    public function subCategory(): BelongsTo
//    {
//        return $this->belongsTo(SubCategory::class,'PartSubCategoryID','PartSubCategoryID');
//    }
//
//    public function workCenter(): BelongsTo
//    {
//        return $this->belongsTo(WorkCenter::class,'WorkCenterID','WorkCenterID');
//    }
//
//    public function country(): BelongsTo
//    {
//        return $this->belongsTo(Country::class,'CountryID','CountryID');
//    }
//
//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class,'UserID','id');
//    }
//
//    public function parts(): HasMany
//    {
//        return $this->hasMany(PartReference::class, 'KitID','KitID');
//    }
//
//    public function boxContent(): HasMany
//    {
//        return $this->hasMany(BoxContent::class,'kit_id','KitID');
//    }


    ///RElacionar Kit con BoxContent y
    /// PartKitsData necesita estar relacionado con BoxContent


//    public function setDateManufactured($value)
//    {
//        $this->attributes['DateManufactured'] = Carbon::createFromFormat()
//    }

    public function getDateManufactured() {
        if($this->DateManufactured){
            return $this->DateManufactured->format('m/d/Y');
        }
    }

}
