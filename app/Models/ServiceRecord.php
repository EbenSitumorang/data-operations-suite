<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = [
        'record_code',
        'service_type',
        'region',
        'customer_ref',
        'status',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'received_at' => 'date',
        ];
    }
}