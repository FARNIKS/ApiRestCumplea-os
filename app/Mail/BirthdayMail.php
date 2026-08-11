<?php

namespace App\Mail;

use App\Models\BirthdayConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class BirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $config;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->config = BirthdayConfig::first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Celebraciones de Cumpleaños - OBGROUP',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.birthday',
        );
    }

    /**
     * Encabezados explícitos para forzar el trato corporativo/transaccional
     */
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Auto-Response-Suppress' => 'OOF, AutoReply',
                'X-Report-Abuse-To'        => 'talentohumanocentroa@corporacionob.com',
                'Auto-Submitted'           => 'auto-generated',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
