<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAnswer extends Model
{
    use HasFactory;

    public function answer_det()
    {
        return $this->belongsTo(DescriptionList::class,'answer_id','id');
    }
}
