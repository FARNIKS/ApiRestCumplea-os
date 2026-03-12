<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            color: #0056b3;
        }

        .alert {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Reporte de Calidad de Datos - Recursos Humanos</h2>
    <p>Los siguientes registros de personal presentan inconsistencias en sus fechas de nacimiento y requieren revisión
        manual:</p>

    <table>
        <thead>
            <tr>
                <th>ID Empleado</th>
                <th>Nombre Completo</th>
                <th>Fecha en Sistema</th>
                <th>Motivo de Alerta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auditRecords as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->birthday ? $employee->birthday->format('d/m/Y') : 'VACÍO' }}</td>
                    <td class="alert">
                        {{ is_null($employee->birthday) ? 'Fecha no definida' : 'Edad fuera de rango lógico' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;"><em>* Este reporte excluye automáticamente registros marcados como "Dynamics Ax
            2012".</em></p>
</body>

</html>
