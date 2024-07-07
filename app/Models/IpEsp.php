<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpEsp extends Model
{
    use HasFactory;
    protected $primaryKey = 'ipesp_id';
    protected $table = 'ip_esps';
    protected $fillable = [
        'ip_esp',
    ];
}
