<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyEvent extends Model
{
    use HasFactory;

    public $table = "myevents";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "name",
        "description",
        "type",
        "start_date",
        "start_time",
        "end_date",
        "end_time",
        "whole_week",

    ];
}
