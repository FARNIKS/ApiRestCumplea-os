<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reporte de Integridad de Datos</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: transparent;
            padding: 40px 24px;
            color: #334155;
            margin: 0;
        }

        .audit-card {
            width: 850px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.03);
            border: 1px solid #e2e8f0;
        }

        .audit-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            background-color: #0f172a;
            padding: 36px 40px;
            border-bottom: 4px solid #2563eb;
        }

        .audit-header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .audit-header p {
            color: #cbd5e1;
            font-size: 14.5px;
            margin: 0 0 16px 0;
            line-height: 1.5;
            font-weight: 400;
        }

        .audit-date {
            color: #38bdf8;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .audit-body {
            padding: 35px;
        }

        .table-container-custom {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-top: 10px;
            border: 1px solid #e2e8f0;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.8px;
            border-bottom: 2px solid #cbd5e1;
            border-right: 1px solid #cbd5e1;
            padding: 16px 12px;
            vertical-align: middle;
            text-align: center;
        }

        .table-custom thead th:first-child {
            border-top-left-radius: 11px;
        }

        .table-custom thead th:last-child {
            border-top-right-radius: 11px;
            border-right: none;
        }

        .table-custom tbody td {
            padding: 18px 12px;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            font-size: 14px;
            color: #334155;
            vertical-align: middle;
            text-align: center;
        }

        .table-custom tbody td:last-child {
            border-right: none;
        }

        .table-custom tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:last-child td:first-child {
            border-bottom-left-radius: 11px;
        }

        .table-custom tbody tr:last-child td:last-child {
            border-bottom-right-radius: 11px;
        }

        .emp-id {
            font-weight: 600;
            color: #64748b;
            font-variant-numeric: tabular-nums;
        }

        .emp-name {
            font-weight: 600;
            color: #0f172a;
        }

        .company-name {
            font-weight: 600;
            color: #475569;
        }

        .status-badge {
            font-weight: 600;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        .status-badge.warning {
            color: #b45309;
            background-color: #fef3c7;
            border: 1px solid #fde68a;
        }

        .status-badge.error {
            color: #b91c1c;
            background-color: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .date-main {
            display: block;
            font-weight: 600;
            color: #334155;
        }

        .date-sub {
            color: #64748b;
            font-size: 12px;
            display: block;
            margin-top: 2px;
        }

        .date-empty {
            color: #94a3b8;
            font-style: italic;
        }

        .audit-footer {
            background-color: #f8fafc;
            padding: 24px 35px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #64748b;
            text-align: center;
            letter-spacing: 0.3px;
        }
    </style>
</head>

<body>
    <div class="audit-card">
        <div class="audit-header">
            <h1>Calidad de Datos: Gestión de Personal</h1>
            <p>Reporte automático de colaboradores con fechas no registradas o rangos de edad inválidos.</p>
            <div class="audit-date">🕒 Generado el: {{ now()->format('d/m/Y') }}</div>
        </div>

        <div class="audit-body">
            <div class="table-container-custom">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th width="16%">Cédula</th>
                            <th width="20%">Empresa</th>
                            <th width="24%">Colaborador</th>
                            <th width="20%">Fecha en Sistema</th>
                            <th width="20%">Motivo de Alerta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auditRecords as $employee)
                            <tr>
                                <td class="emp-id">{{ $employee->Cedula }}</td>
                                <td class="company-name">{{ $employee->Empresa }}</td>
                                <td class="emp-name">{{ $employee->Nombre }}</td>
                                <td>
                                    @if ($employee->Cumple)
                                        <span class="date-main">{{ $employee->Cumple->format('d/m/Y') }}</span>
                                        <span class="date-sub">({{ $employee->Cumple->age }} años)</span>
                                    @else
                                        <span class="date-empty">No registrada</span>
                                    @endif
                                </td>
                                <td>
                                    @if (is_null($employee->Cumple))
                                        <span class="status-badge warning">⚠️ No definida</span>
                                    @else
                                        <span class="status-badge error">🚫 Edad inválida</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="audit-footer">
            <div><strong>Este reporte excluye automáticamente registros marcados como "Dynamics Ax 2012"</strong></div>
        </div>
    </div>
</body>

</html>
