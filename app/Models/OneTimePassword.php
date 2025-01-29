<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (OneTimePassword $otp) {
            $code = mt_rand(100_000, 999_999);
            $otp->code = $code;
        });
    }
}
