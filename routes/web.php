<?php

use App\Models\Branch;
use App\Models\Assignment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // 1. Cargamos sucursales agrupadas
    $branches = Branch::with('company')->get()
        ->groupBy(fn($b) => $b->company->name ?? 'Sin Empresa')
        ->map(fn($items, $comp) => [
            'label' => $comp,
            'options' => $items->map(fn($i) => ['value' => $i->id, 'text' => $i->name])
        ]);

    // 2. Cargamos asignaciones agrupadas
    $assignments = Assignment::with(['position', 'department'])->get()
        ->groupBy(fn($asig) => $asig->department->name ?? 'Sin Departamento')
        ->map(fn($items, $dept) => [
            'label' => $dept,
            'options' => $items->map(fn($item) => ['value' => $item->id, 'text' => $item->position->name])
        ]);

    // 3. PASAR LAS VARIABLES A LA VISTA (Esto es lo que falta)
    return view('welcome', compact('branches', 'assignments'));
});
