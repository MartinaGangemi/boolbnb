<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest_View extends Model
{
    protected $fillable = ['ip_address', 'visited_at','apartment_id'];

    public function apartment() {
        return $this->belongsTo(Apartment::class);
    }
}
