<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperEvent
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title','description','date','location','created_by'];

    public function user() { return $this->belongsTo(User::class, 'created_by'); }
    public function tickets() { return $this->hasMany(Ticket::class); }
}

