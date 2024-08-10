<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transfer extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->transfer_id)) {
                $model->transfer_id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'user_receive_amount',
        'amount',
        'remaks'
    ];


}
