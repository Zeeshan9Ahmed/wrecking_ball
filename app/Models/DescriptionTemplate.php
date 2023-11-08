<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionTemplate extends Model
{
    use HasFactory;

    public function answers()
    {
        return $this->hasMany(DescriptionList::class,'description_template_id','id');
    }

    public function media()
    {
        return $this->hasMany(DescriptionMedia::class,'description_template_id','id');
    }

    public function comments()
    {
        return $this->hasMany(DescriptionComment::class,'description_template_id','id');
    }
}
