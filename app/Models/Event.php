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
        "room_id",
        "event_name",
        "description",
        "type",
        "start_date",
        "start_time",
        "end_date",
        "end_time",
        "participants",
        "target_dept",
        "target_org",
        "event_letter",
        "feedback_image",
        "status",
        "receipt_image",
        "org_adviser",
        "sect_head",
        "dept_head",
        "osa",
        "adaa",
        "atty",
        "campus_director",
        "remarks_org_adviser",
        "remarks_sec_head",
        "remarks_dept_head",
        "remarks_osa",
        "remarks_adaa",
        "remarks_atty",
        "remarks_campus_director",
        "remarks_business_manager",
        "color",
        "created_at"

    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }
}
