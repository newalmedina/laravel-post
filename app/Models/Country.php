<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";
    protected $fillable = ['name',  'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
