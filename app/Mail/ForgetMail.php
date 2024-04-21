<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class ForgetMail extends Mailable
{
    use Queueable, SerializesModels;
    //add a token as public
    public $token;
    /**
     * Create a new message instance.
     * 
     */
    public function __construct($token)
    {
        //pass $token
        $this->data = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //add details
            from: new Address('gallardosarahgin2020@gmail.com','Sarah'),
            replyTo: [new Address('gallardosarahgin2023@gmail.com','Sarah2'),],
            subject: 'Password Reset Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //send to forget page
            view:'mail.forget',
            //attached the pincode or token
            with: ['data'=> $this->data],
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
