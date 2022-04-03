<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Song
 * @package App\Models
 */
class Song extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'url', 'duration', 'artist_name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['duration_for_human'];


    /**
     * @return string
     * @throws \Exception
     */
    public function getDurationForHumanAttribute()
    {
        return CarbonInterval::seconds($this->attributes['duration'])->cascade()->forHumans();
    }
}
