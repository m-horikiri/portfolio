<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAdsData extends Model
{
    use HasFactory;
    protected $table = 'google_ads_datas';
    protected $fillable = ['name', 'media', 'gclid', 'acceptanceTime', 'conversionTime', 'conversionValue'];
}
