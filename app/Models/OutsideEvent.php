<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutsideEvent extends Model
{
    use HasFactory;
    public $table = "outside_events";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "event_id",
        "quotation",
        "amount",
        "reason",
        "status",
        "created_at",
        "updated_at",
    ];
}
