<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public $table = "staffs";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "firstname",
        "lastname",
        "tupId",
        "department_id",
        "role",
        "user_id"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
