<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'description',
        'weeknumber',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_event', 'event_id', 'order_id');
    }
    
}
