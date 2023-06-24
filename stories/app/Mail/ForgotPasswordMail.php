<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
   
    public function __construct($data)
    {
        $this->data = $data;
        // $this->afterCommit();
    }

  
    public function envelope(): Envelope
    {
        return new Envelope( 
            from: new Address('huybmt2527000@gmail.com'),
            replyTo: [
                new Address('huybmt2527000@gmail.com'),
            ],
            subject: 'Forgot Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pages.forgot',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
