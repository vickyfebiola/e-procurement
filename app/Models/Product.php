<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_product';
    public $incrementing = false;
    protected $guarded = [''];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }
}
