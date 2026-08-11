<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ProcessErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $errorDetails;

    public function __construct(array $errorDetails)
    {
        $this->errorDetails = $errorDetails;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ALERTA URGENTE: Actualización Incompleta de Base de Datos de Personal',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.processError',
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
