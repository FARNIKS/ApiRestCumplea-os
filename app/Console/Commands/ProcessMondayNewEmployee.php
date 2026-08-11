<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewEmployeeMailService;
use App\Mail\NewEmployeesReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryEmployee;
use App\Models\NewEmployee;
use App\Models\NewEmployeeReportConfig;

class ProcessMondayNewEmployee extends Command
{
    protected $signature = 'app:process-monday-new-employees';
    protected $description = 'Envía el correo masivo de nuevos ingresos y los mueve a la tabla de historial.';

    public function handle(NewEmployeeMailService $service)
    {
        $data = $service->getProcessedNewEmployees();

        if (!$data || (is_array($data) && empty($data['raw_collection']))) {
            $this->info('No hay nuevos ingresos pendientes para enviar.');
            return;
        }

        $config = NewEmployeeReportConfig::first();

        $bccList = [
            'obarquero@corporacionob.com',
            'orbecostarica@orbe.co.cr',
            'orbepanama@orbe.com.pa',
            'orbenicaragua@orbe.com.ni',
            'orbehonduras@orbe.com',
            'orbesalvador@orbe.com.sv',
            'orbeguatemala@orbe.com.gt',
            'orbecolombia@corpob.onmicrosoft.com',
            'siscon@siscon.co.cr',
            'TodoelPersonal@corpob.onmicrosoft.com',
            'TodoElPersonalCR@corpob.onmicrosoft.com',
            'todoelpersonalcentroamerica@corpob.onmicrosoft.com'
        ];

        try {
            DB::transaction(function () use ($data) {
                $coleccion = is_array($data) ? $data['raw_collection'] : $data;

                foreach ($coleccion as $emp) {

                    $cedula       = $emp->cedula ?? $emp->Cedula ?? null;
                    $nombre       = $emp->nombre ?? $emp->Nombre ?? null;
                    $puesto       = $emp->puesto ?? $emp->Puesto ?? $emp->cargo ?? null;
                    $centroCosto  = $emp->centro_costo ?? $emp->Centro_Costo ?? $emp->dimensiones ?? null;
                    $empresaCode  = $emp->empresa_code ?? $emp->Empresa ?? null;

                    $fechaIngresoRaw = $emp->fecha_ingreso ?? $emp->Fecha_Ingreso ?? null;
                    $fechaIngreso    = $fechaIngresoRaw instanceof \DateTimeInterface
                        ? $fechaIngresoRaw->format('Y-m-d')
                        : $fechaIngresoRaw;

                    if ($cedula) {
                        $registroLocal = NewEmployee::where('cedula', $cedula)->first();

                        if ($registroLocal) {
                            HistoryEmployee::create([
                                'cedula'        => $registroLocal->cedula,
                                'nombre'        => $registroLocal->getRawOriginal('nombre') ?? $registroLocal->nombre,
                                'puesto'        => $registroLocal->puesto,
                                'centro_costo'  => $registroLocal->centro_costo,
                                'empresa_code'  => $registroLocal->empresa_code,
                                'fecha_ingreso' => $registroLocal->fecha_ingreso,
                                'fecha_envio'   => now(),
                            ]);

                            $registroLocal->delete();
                        } else {

                            HistoryEmployee::create([
                                'cedula'        => $cedula,
                                'nombre'        => $nombre,
                                'puesto'        => $puesto,
                                'centro_costo'  => $centroCosto,
                                'empresa_code'  => $empresaCode,
                                'fecha_ingreso' => $fechaIngreso,
                                'fecha_envio'   => now(),
                            ]);
                        }
                    }
                }
            });

            $this->info('Traspaso de base de datos completado en local. Procediendo a enviar el correo...');

            Mail::to('talentohumanocentroa@corporacionob.com')
                ->bcc($bccList)
                ->send(new NewEmployeesReport($data, $config));

            $this->info('Proceso de lunes completado con éxito: Correos enviados y datos movidos a historial.');
        } catch (\Exception $e) {
            $this->error('Error durante el proceso del lunes: ' . $e->getMessage());
        }
    }
}
