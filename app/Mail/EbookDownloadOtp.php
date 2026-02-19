<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EbookDownloadOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;
    public $ebookTitle;

    /**
     * Create a new message instance.
     */
    public function __construct($otp, $name, $ebookTitle)
    {
        $this->otp = $otp;
        $this->name = $name;
        $this->ebookTitle = $ebookTitle;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code for ' . $this->ebookTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.ebook-otp',
            with: [
                'otp' => $this->otp,
                'name' => $this->name,
                'ebookTitle' => $this->ebookTitle,
            ],
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
