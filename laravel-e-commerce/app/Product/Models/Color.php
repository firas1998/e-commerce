<?php

namespace App\Product\Models;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}
