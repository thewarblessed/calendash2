<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    public $table = "venues";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "name",
        "description",
        "capacity",
        "image",
    ];

    public function event() {
        return $this->hasMany('App\Models\Event', 'venue_id');
    }
}
