<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperBooking
 */
class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','ticket_id','quantity','status'];

    public function user() { return $this->belongsTo(User::class); }
    public function ticket() { return $this->belongsTo(Ticket::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}
