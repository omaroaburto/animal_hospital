<?php

namespace App\Domains\Inventary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\ProductBatchFactory;

class ProductBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        //
    ];

    protected static function newFactory(): Factory
    {
        return ProductBatchFactory::new();
    }
}