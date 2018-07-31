<?php

namespace Droplister\JobCore\App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filters',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'filters' => 'array',
    ];

    /**
     * Users
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('expired_at');
    }

    /**
     * Users (active)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeUsers()
    {
        return $this->belongsToMany(User::class)->withPivot('expired_at')
        	->wherePivot('expired_at', '>', Carbon::now());
    }
}