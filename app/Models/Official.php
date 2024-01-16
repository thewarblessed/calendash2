<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;
    public $table = "officials";
    public $timestamps = false;
    public $primaryKey = "id";
    public $guarded = [
        "id"
    ];

    protected $fillable = [
        "user_id",
        "hash"
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
