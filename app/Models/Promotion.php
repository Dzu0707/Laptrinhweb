<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',       // percent | fixed
        'value',
        'start_at',
        'end_at',
        'active'
    ];

    public function isValid()
    {
        $now = now();
        return $this->active && $this->start_at <= $now && $this->end_at >= $now;
    }
}
