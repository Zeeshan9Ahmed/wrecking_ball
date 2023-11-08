<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_template_name', 'order'
    ];
}
