<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $table = "events";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "user_id",
        "venue_id",
        "eventName",
        "description",
        "event_date",
        "participants",
        "target_dept",
        "status",
        "dept_head",
        "adaa",
        "atty",
        "osa"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }
}
