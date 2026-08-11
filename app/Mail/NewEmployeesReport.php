<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use App\Models\NewEmployeeReportConfig;

class NewEmployeesReport extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $config;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->config = NewEmployeeReportConfig::first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Incorporación de nuevos colaboradores - OBGROUP', // Se cambió el '¡Bienvenidos!' para evitar filtros de spam/promociones
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reportNewEmployes',
        );
    }

    /**
     * Agrega encabezados para forzar el trato de correo interno/transaccional
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
}
