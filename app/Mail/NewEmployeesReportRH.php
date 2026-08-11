<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use App\Models\NewEmployeeReportRhConfig;

class NewEmployeesReportRH extends Mailable
{
    use Queueable, SerializesModels;

    public $hires;
    public $config;

    public function __construct($groupedHires)
    {
        $this->hires = $groupedHires;
        $this->config = NewEmployeeReportRhConfig::first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte Semanal - Nuevos Ingresos Programados para el Lunes',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reportNewEmployesRH',
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
}
