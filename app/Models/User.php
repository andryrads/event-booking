<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name','email','password','phone','role'];

    public function events() { return $this->hasMany(Event::class, 'created_by'); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
