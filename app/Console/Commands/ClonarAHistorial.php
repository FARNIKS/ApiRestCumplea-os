<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExternalEmployee;
use App\Models\NewEmployee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClonarAHistorial extends Command
{
    protected $signature = 'db:clonar-historial';

    protected $description = 'Sincroniza el espejo histórico completo con el pasado de AX y llena la sala de espera de NewEmployees con la semana actual';

    public function handle()
    {
        $this->info('Iniciando sincronización global del espejo histórico y sala de espera...');

        $haceUnaSemana = Carbon::now()->subDays(7)->startOfDay();

        $empleadosAntiguosAX = ExternalEmployee::where('Fecha_Ingreso', '<', $haceUnaSemana)->get();

        $this->info("Clonando " . $empleadosAntiguosAX->count() . " registros antiguos al histórico local...");

        DB::transaction(function () use ($empleadosAntiguosAX, $haceUnaSemana) {

            DB::table('history_employees')->truncate();

            foreach ($empleadosAntiguosAX as $emp) {
                DB::table('history_employees')->insert([
                    'cedula'        => $emp->Cedula,
                    'nombre'        => $emp->getRawOriginal('Nombre') ?? $emp->Nombre,
                    'centro_costo'  => $emp->{'Centro de costo'} ?? 'Sin Centro de Costo',
                    'puesto'        => $emp->Puesto ?? null,
                    'empresa_code'  => $emp->Empresa,
                    'fecha_ingreso' => $emp->Fecha_Ingreso ? $emp->Fecha_Ingreso->format('Y-m-d') : null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            $this->info('¡Espejo histórico local de comparación actualizado correctamente!');

            $nuevosEstaSemana = ExternalEmployee::where('Fecha_Ingreso', '>=', $haceUnaSemana)->get();

            $this->info("Cargando " . $nuevosEstaSemana->count() . " ingresos nuevos en la sala de espera...");

            DB::table('new_employees')->truncate();

            foreach ($nuevosEstaSemana as $nuevo) {
                NewEmployee::create([
                    'cedula'        => $nuevo->Cedula,
                    'nombre'        => $nuevo->getRawOriginal('Nombre') ?? $nuevo->Nombre,
                    'centro_costo'  => $nuevo->{'Centro de costo'} ?? 'Sin Centro de Costo',
                    'puesto'        => $nuevo->Puesto ?? null,
                    'empresa_code'  => $nuevo->Empresa,
                    'fecha_ingreso' => $nuevo->Fecha_Ingreso ? $nuevo->Fecha_Ingreso->format('Y-m-d') : null,
                    'enviado'       => false,
                ]);
            }
        });

        $this->info('¡Sincronización finalizada con éxito! Sistema balanceado.');
    }
}
