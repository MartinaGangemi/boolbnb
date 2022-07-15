<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['fullname', 'email', 'description', 'apartment_id'];
    public function apartment() {
        return $this->belongsTo(Apartment::class);
    }
}
