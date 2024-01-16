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
        "event_name",
        "description",
        "event_date",
        "start_time",
        "end_time",
        "participants",
        "target_dept",
        "event_letter",
        "status",
        "sect_head",
        "dept_head",
        "osa",
        "adaa",
        "atty",
        "campus_director"

    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }
}
