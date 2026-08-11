<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExternalEmployee;
use App\Models\NewEmployee;
use App\Models\HistoryEmployee;
use Carbon\Carbon;

class SyncNewEmployees extends Command
{
    protected $signature = 'employees:sync-new';
    protected $description = 'Sincroniza los nuevos ingresos desde AX a la sala de espera intermedia protegiéndose con el histórico local';

    public function handle()
    {
        $this->info('Iniciando sincronización de nuevos ingresos...');

        $haceUnaSemana = Carbon::now()->subDays(7)->startOfDay();
        $hoy = Carbon::now()->endOfDay();

        $candidatosAX = ExternalEmployee::whereBetween('Fecha_Ingreso', [$haceUnaSemana, $hoy])->get();
        $nuevosRegistrados = 0;

        foreach ($candidatosAX as $candidato) {

            $yaExisteEnHistorial = HistoryEmployee::where('cedula', $candidato->Cedula)->exists();

            if ($yaExisteEnHistorial) {
                continue;
            }

            $yaEstaEnSalaEspera = NewEmployee::where('cedula', $candidato->Cedula)->exists();

            if (!$yaEstaEnSalaEspera) {
                NewEmployee::create([
                    'cedula'        => $candidato->Cedula,
                    'nombre'        => $candidato->Nombre,
                    'centro_costo'  => $candidato->{'Centro de costo'} ?? 'Sin Centro de Costo',
                    'puesto'        => $candidato->Puesto ?? null,
                    'empresa_code'  => $candidato->Empresa,
                    'cumple'        => $candidato->Cumple ? $candidato->Cumple->format('Y-m-d') : null,
                    'fecha_ingreso' => $candidato->Fecha_Ingreso ? $candidato->Fecha_Ingreso->format('Y-m-d') : null,
                    'enviado'       => false,
                ]);

                $nuevosRegistrados++;
            }
        }

        $this->info("Sincronización completada. Se añadieron {$nuevosRegistrados} empleados a la sala de espera.");
    }
}
