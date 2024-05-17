<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $title, $content)
    {
        $this->subject = $subject;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.post')
            ->subject($this->subject)
            ->with([
                'title' => $this->title,
                'content' => $this->content
            ]);
    }
}
