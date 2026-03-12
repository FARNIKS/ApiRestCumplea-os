<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BirthdayService;
use App\Mail\BirthdayMail;
use App\Mail\NoBirthdaysMail;
use App\Mail\ProcessErrorMail;
use App\Mail\DataQualityMail;
use Illuminate\Support\Facades\Mail;

class SendDailyBirthdays extends Command
{
    protected $signature = 'app:send-daily-birthdays';
    protected $description = 'Procesa y envía los correos de cumpleaños y frases diarias de OBGROUP';

    /**
     * Ejecuta la lógica del comando.
     */
    public function handle(BirthdayService $service)
    {
        // 1. Obtener datos procesados del servicio
        $data = $service->getProcessedBirthdays();

        // --- CASO A: ERROR DE INTEGRIDAD (Quórum < 550) ---
        if (is_null($data)) {
            $recipients = ['jquesada@corporacionob.com', 'mjimenezf@elorbe.la'];

            Mail::to($recipients)->send(new ProcessErrorMail([
                'message' => 'ALERTA URGENTE: Actualización Incompleta de Base de Datos (Menos de 550 registros)',
                'timestamp' => now()->toDateTimeString()
            ]));

            $this->error('Fallo de quórum. Alerta técnica enviada.');
            return;
        }

        // --- DESTINATARIOS DE PRODUCCIÓN ---
        $mainRecipient = 'talentohumanocentroa@corporacionob.com';

        $bccList = [
            'obarquero@corporacionob.com',
            'aalfaro@corporacionob.com',
            'orbecostarica@corporacionob.com',
            'orbepanama@corporacionob.com',
            'orbenicaragua@corporacionob.com',
            'orbehonduras@corporacionob.com',
            'orbesalvador@corporacionob.com',
            'orbeguatemala@corporacionob.com',
            'orbecolombia@corporacionob.com',
            'siscon@corporacionob.com',
            'TodoelPersonal@corporacionob.com',
            'TodoElPersonalCR@corporacionob.com',
            'todoelpersonalcentroamerica@corporacionob.com'
        ];

        // --- CASO B: HAY CUMPLEAÑEROS ---
        if ($data['birthdays']->isNotEmpty()) {
            Mail::to($mainRecipient)
                ->bcc($bccList)
                ->send(new BirthdayMail($data));

            $this->info('Correos de felicitación enviados masivamente.');
        }
        // --- CASO C: DÍA SIN CUMPLEAÑOS ---
        else {
            Mail::to($mainRecipient)
                ->bcc($bccList)
                ->send(new NoBirthdaysMail($data));

            $this->info('Correo de día sin cumpleaños enviado.');
        }

        // --- PASO 4: REPORTE DE AUDITORÍA ---
        $this->processAuditReport($service);
    }

    private function processAuditReport(BirthdayService $service)
    {
        $auditRecords = $service->getAuditRecords();

        if ($auditRecords->isNotEmpty()) {
            $auditRecipients = ['aalfaro@corporacionob.com', 'mcabreram@corporacionob.com'];

            Mail::to($auditRecipients)
                ->send(new DataQualityMail($auditRecords));

            $this->warn('Reporte de calidad de datos enviado a auditoría.');
        }
    }
}
