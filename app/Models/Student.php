<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $table = "students";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "firstname",
        "lastname",
        "tupId",
        "course",
        "yearLevel",
        "department",
        "section",
        "studOrg",
        "role",
        "user_id"
    ];
}
