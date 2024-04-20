<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccomplishmentReports extends Model
{
    use HasFactory;
    public $table = "accomplishmentreports";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = ["id"];
}
