<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    use HasFactory;
    protected $primaryKey = 'health_id';
    protected $table = 'health';
    protected $fillable = [
        'bpm',
        'oksigen',
        'created_at',
    ];
}
