<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /** @use HasFactory<\Database\Factories\PricingFactory> */
    use HasFactory;

    protected $fillable = [
        "type"
    ];
}
