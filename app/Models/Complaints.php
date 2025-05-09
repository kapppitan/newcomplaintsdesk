<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_type',
        'complaint_type',
        'details',
        'email',
        'phone',
    ];

    protected $casts = [
        'date_verified' => 'datetime',
    ];

    public function ticket () 
    {
        return $this->belongsTo(Ticket::class);
    }
}
