<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedShortLink extends Model
{
    public $timestamps = true;
    protected $table = 'used_short_url';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_url',
        'short_url_id',
        'description',
        'visited_no'
        ];

}
