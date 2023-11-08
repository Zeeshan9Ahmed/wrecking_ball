<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDescription extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(DescriptionTemplate::class,'description_id','id');
    }

    public function answer()
    {
        return $this->belongsTo(BookingAnswer::class,'booking_id','booking_id');
    }
}
