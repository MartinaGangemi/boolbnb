<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  public function services() {
    return $this->belongsToMany(Service::class);
  }

  public function sponsorships() {
    return $this->belongsToMany(Sponsorship::class);
  }

  public function messages() {
    return $this->hasMany(Message::class);
  }

  public function guest_views() {
    return $this->hasMany(Guest_View::class);
  }
}
