<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProcessErrorMail extends Mailable
{
    use Queueable, SerializesModels;


    public $errorDetails;
    /**
     * Create a new message instance.
     */
    public function __construct(array $errorDetails)
    {
        // Recibe un arreglo con 'message', 'code' y 'timestamp'
        $this->errorDetails = $errorDetails;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ALERTA URGENTE: Actualización Incompleta de Base de Datos de Personal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.processError',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
