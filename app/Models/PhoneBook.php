<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'image',
        'address',
        'long',
        'lat',
        'nid',
    ];


    public function getImageAttribute($value)
    {
        if ($value) {
            return url(asset('storage/' . $value));
        }
        return null;
    }
}
