<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'apartment',
        'city',
        'phone',
        'email',
        'user_id',
        'is_default',
        'country',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
