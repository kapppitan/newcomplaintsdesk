<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'complaintforms';

    protected $dates = [
        'acknowledgedqao_on',
        'implementation',
        'acknowledged_on'
    ];

    protected $fillable = [
        'complaint_id',
        'validated_by',
        'validated_on',
        'acknowledgedqao_on',
        'acknowledgedqao_by',
        'immediate_action',
        'consequence',
        'root_cause',
        'nonconformity',
        'corrective_action',
        'implementation',
        'measure',
        'period',
        'responsible',
        'risk_opportunity',
        'prepared_on',
        'prepared_by',
        'approved_on',
        'approved_by',
        'acknowledged_on',
        'acknowledged_by',
        'reported_by',
        'is_approved',
    ];
}
