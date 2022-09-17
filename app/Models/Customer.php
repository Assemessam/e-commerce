<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'commercial_registration_no',
        'vat_registration_no'
    ];
    public function user()
    {
        return $this->morphOne('App\User', 'profile');
    }
}
