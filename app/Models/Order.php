<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    public function events()
    {
        return $this->belongsToMany(Event::class, 'order_event', 'order_id', 'event_id');
    }
}
