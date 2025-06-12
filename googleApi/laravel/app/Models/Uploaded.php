<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploaded extends Model
{
    use HasFactory;
    protected $table = 'uploaded_conversions';
    protected $fillable = ['status', 'validate_only', 'name', 'customer_id', 'gclid', 'conversion_action_id', 'conversion_date_time', 'conversion_value', 'order_id'];
}
