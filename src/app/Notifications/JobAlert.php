<?php

namespace Droplister\JobCore\App\Notifications;

use Droplister\JobCore\App\Alert;
use Droplister\JobCore\App\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class JobAlert extends Notification
{
    use Queueable;

    protected $alert;
    protected $listings;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Alert $alert, Listing $listings)
    {
        $this->alert = $alert;
        $this->listings = $listings;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('There are new jobs matching your search.')
                    ->action('Review Jobs', route('search.index', $this->alert->filters))
                    ->line('Thank you for using our application!');
    }

	/**
	 * Get the Slack representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return SlackMessage
	 */
	public function toSlack($notifiable)
	{
	    return (new SlackMessage)
	                ->content('There are new jobs matching your search.');
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}