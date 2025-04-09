<?php

namespace App\Mail;

use App\Models\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    public function build()
    {
        return $this->subject('Phản hồi từ Admin')
            ->view('emails.admin_reply')
            ->with(['rating' => $this->rating]);
    }
}
