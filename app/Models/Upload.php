<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'user_id',
        'nid_f',
        'nid_b',
        'military_report',
        'criminal_record',
        'certificate',
    ];
}
