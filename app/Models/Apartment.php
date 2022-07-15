<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['user_id', 'summary', 'rooms', 'beds', 'bathrooms', 'square_meters', 'cover_img', 'slug', 'visible','description','address','lat','lon'];

    public static function generateSlug($summary)
    {
        # code...
        return Str::slug($summary, '-');
    }

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
