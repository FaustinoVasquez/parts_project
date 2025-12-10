<?php

namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\WorkCenter;
use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class ReferenceDataCache
{
    /**
     * Cache duration in seconds (24 hours)
     */
    const CACHE_TTL = 86400;

    /**
     * Get all work centers (cached)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function workCenters()
    {
        return Cache::remember('reference_data.work_centers', self::CACHE_TTL, function () {
            return WorkCenter::all();
        });
    }

    /**
     * Get all categories (cached)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function categories()
    {
        return Cache::remember('reference_data.categories', self::CACHE_TTL, function () {
            return Category::all();
        });
    }

    /**
     * Get all sub-categories (cached)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function subCategories()
    {
        return Cache::remember('reference_data.sub_categories', self::CACHE_TTL, function () {
            return SubCategory::all();
        });
    }

    /**
     * Get all countries (cached)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function countries()
    {
        return Cache::remember('reference_data.countries', self::CACHE_TTL, function () {
            return Country::all();
        });
    }

    /**
     * Clear all reference data caches
     *
     * @return void
     */
    public static function clearAll()
    {
        Cache::forget('reference_data.work_centers');
        Cache::forget('reference_data.categories');
        Cache::forget('reference_data.sub_categories');
        Cache::forget('reference_data.countries');
    }

    /**
     * Warm up all caches
     *
     * @return void
     */
    public static function warmUp()
    {
        self::workCenters();
        self::categories();
        self::subCategories();
        self::countries();
    }
}
