<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  public function services() {
    return $this->belongsToMany(Service::class);
  }
}
