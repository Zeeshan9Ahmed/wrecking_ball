<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSubTemplate extends Model
{
    use HasFactory;

    public function template()
    {
        return $this->belongsTo(Template::class,'template_id','id');
    }
    public function sub_template()
    {
        return $this->belongsTo(SubTemplate::class,'sub_template_id','id');
    }
}
