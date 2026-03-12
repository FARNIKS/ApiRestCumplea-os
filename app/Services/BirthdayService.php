<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\BirthdayMessage;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BirthdayService
{
    // Variable protegida para evitar "números mágicos" y facilitar el mantenimiento [1]
    protected $maxAge = 100;

    /**
     * Procesa los cumpleañeros del día aplicando filtros dinámicos y de integridad.
     */
    public function getProcessedBirthdays(): ?array
    {
        // 1. Validación de Integridad (Quórum < 550) [Reglas de Negocio]
        // Realizamos un conteo rápido antes de cargar relaciones pesadas [2]
        if (Employee::where('estado', true)->count() < 550) {
            return null;
        }

        // 2. Selección de frase del día (ID 1-366) [Reglas de Negocio, 1202]
        $message = BirthdayMessage::find(now()->dayOfYear)?->phrase
            ?? "¡Felicidades en tu día!";

        // 3. Consulta optimizada con Eager Loading [3, 4]
        $birthdays = Employee::with(['branch.company', 'assignment.position'])
            ->where('estado', true)
            ->whereRaw("FORMAT(birthday, 'MM-dd') = ?", [now()->format('m-d')])
            ->get()
            // Filtro dinámico: Excluye registros que superen el límite de edad [Reglas de Negocio]
            ->filter(fn($employee) => $employee->birthday->age < $this->maxAge)
            // Regla: No duplicados por nombre en el mismo envío [1366, Reglas de Negocio]
            ->unique('name');

        if ($birthdays->isEmpty()) {
            return ['phrase' => $message, 'birthdays' => collect()];
        }

        // 4. Agrupación Jerárquica [Reglas de Negocio, 1366]
        $groupedData = $birthdays->groupBy([
            fn($e) => $e->branch?->country ?? 'Otros',
            fn($e) => $e->branch?->company?->name ?? 'N/A'
        ]);

        return [
            'phrase' => $message,
            'birthdays' => $groupedData
        ];
    }

    /**
     * Reporte de Auditoría: Detecta datos inconsistentes usando el mismo límite de edad.
     */
    public function getAuditRecords(): Collection
    {
        return Employee::where('estado', true)
            ->where(function ($query) {
                $query->whereNull('birthday')
                    // Identifica registros que superan el límite lógico establecido [Reglas de Negocio]
                    ->orWhereYear('birthday', '<', now()->year - $this->maxAge);
            })
            // Exclusión técnica de registros legacy [Reglas de Negocio]
            ->where('name', 'NOT LIKE', '%Dynamics Ax 2012%')
            ->get();
    }
}
