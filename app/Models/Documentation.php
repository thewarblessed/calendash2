<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    public $table = "documentations";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = ["id"];

    protected $fillable = [
        "accomplishmentreports_id",
        "image",
    ];
}
