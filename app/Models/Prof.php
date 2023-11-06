<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prof extends Model
{
    use HasFactory;

    public $table = "professors";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "firstname",
        "lastname",
        "tupId",
        "department",
        "organization",
        "role"
    ];
}
