<?php

declare(strict_types=1);

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Account\Database\Factories\ProfileFactory;

class Profile extends Model
{
    use HasFactory;

    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'icon',
        'name',
        'name_kana',
        'contract_type',
        'post_code',
        'address',
        'phone_number',
        'birthday',
        'hire_date',
        'emergency_name',
        'emergency_phone_number',
        'emergency_relationship',
    ];

    protected function casts(): array
    {
        return [
            'birthday' => 'immutable_date',
            'hire_date' => 'immutable_date',
        ];
    }
}
