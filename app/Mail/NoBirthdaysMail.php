<?php

namespace App\Mail;

use App\Models\NoBirthdayConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class NoBirthdaysMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $config;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->config = NoBirthdayConfig::first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hoy nos preparamos para grandes retos - OBGROUP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.noBirthday',
        );
    }

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Auto-Response-Suppress' => 'OOF, AutoReply',
                'Auto-Submitted'           => 'auto-generated',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
