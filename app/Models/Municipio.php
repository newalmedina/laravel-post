<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'active', 'province_id'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
