<?php

namespace App\Mail;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReviewSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Review $review)
    {
    }

    public function build()
    {
        return $this->subject('Nova avaliação recebida — English School')
            ->view('emails.new-review');
    }
}