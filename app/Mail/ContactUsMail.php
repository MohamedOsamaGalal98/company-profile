<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Contact Us Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }


    public function build()
    {
        return $this->subject('New Contact Us Submission')
            ->html("
                        <h1>New Contact Us Submission</h1>
                        <p><strong>First Name:</strong> {$this->data['firstname']}</p>
                        <p><strong>Last Name:</strong> {$this->data['lastname']}</p>
                        <p><strong>Email:</strong> {$this->data['email']}</p>
                        <p><strong>Subject:</strong> {$this->data['subject']}</p>
                        <p><strong>Message:</strong> {$this->data['message']}</p>
                    ");
    }
}
