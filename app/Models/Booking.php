<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function get_user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function get_template()
    {
        return $this->belongsTo(Template::class,'template_id','id');
    }
}
