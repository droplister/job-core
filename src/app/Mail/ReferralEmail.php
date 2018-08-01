<?php

namespace Droplister\JobCore\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $from;
    public $listing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $listing)
    {
        $this->from = $from;
        $this->listing = $listing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), $this->from . ' via ' . config('job-core.domain'))
            ->replyTo($this->from)
            ->subject($this->listing->title)
            ->markdown('job-core::emails.referral');
    }
}