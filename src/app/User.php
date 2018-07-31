<?php

namespace Droplister\JobCore\App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Alerts
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alerts()
    {
        return $this->belongsToMany(Alert::class)->withPivot('expired_at');
    }

    /**
     * Alerts (active)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeAlerts()
    {
        return $this->belongsToMany(Alert::class)->withPivot('expired_at')
            ->wherePivot('expired_at', '>', Carbon::now());
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return config('job-core.slack_webhook');
    }
}