<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $table = "notifications";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "to_user_id",
        "subject",
        "message",
        "from_user_id",
        "read",
        "is_present",
        "read_at",
        "created_at"
    ];
}
