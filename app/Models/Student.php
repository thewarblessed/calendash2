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
        "organization_id",
        "department_id",
        "section_id",
        "studOrg",
        "user_id"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
