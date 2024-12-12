<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corrective extends Model
{
    use HasFactory;

    protected $table = 'corrective';

    protected $fillable = [
        'corrective_action',
        'implementation_date',
        'effectiveness',
        'monitoring_period',
        'responsible',
        'complaint_id',
    ];
}
