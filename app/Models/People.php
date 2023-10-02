<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'peoples';

    protected $fillable = [
        'apelido',
        'nome',
        'nascimento',
        'stack'
    ];

    public function stack(): Attribute
    {
        return Attribute::make(
            get: fn(string|null $value) => $value ? explode(',', $value) : null,
            set: fn(array|null $value) => $value ? implode(',', $value) : null
        );
    }
}
