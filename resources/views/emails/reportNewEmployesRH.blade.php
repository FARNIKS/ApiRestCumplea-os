<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            line-height: 1.6;
            background-color: transparent;
            margin: 0;
            padding: 40px 20px;
        }

        .main-card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }

        .header-gradient {
            background: #0f172a;
            padding: 30px 25px;
            color: #ffffff;
            border-bottom: 4px solid #3182ce;
        }

        .header-gradient h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .header-date {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .content {
            padding: 30px 25px;
        }

        .summary-box {
            background-color: #f1f5f9;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .summary-text {
            font-size: 15px;
            color: #334155;
            margin: 0;
        }

        .country-group {
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .country-badge {
            background-color: #f8fafc;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .country-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 12.5px;
            letter-spacing: 0.5px;
        }

        .count-pill {
            float: right;
            background: #3182ce;
            color: #ffffff;
            font-size: 10px;
            padding: 3px 12px;
            border-radius: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .employee-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .employee-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
        }

        .employee-item:last-child {
            border-bottom: none;
        }

        .dept-tag {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        .emp-name {
            display: block;
            font-size: 15.5px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .alert-box {
            background-color: #fef1f2;
            border: 1px solid #fee2e2;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
        }

        .alert-text {
            font-size: 13.5px;
            color: #9a3412;
            margin: 0;
            line-height: 1.5;
        }

        .alert-text strong {
            color: #7c2d12;
            font-weight: 700;
        }

        .footer {
            text-align: center;
            padding: 25px;
            font-size: 11px;
            color: #64748b;
            background-color: #f8fafc;
            border-top: 1px solid #f1f5f9;
        }

        .footer-brand {
            color: #475569;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            display: inline-block;
        }
    </style>
</head>

<body style="background-color: transparent;">
    <div class="main-card">
        <div class="header-gradient">
            <h2>{{ $config->title }}</h2>
            <div class="header-date">Reporte Consolidado Semanal • {{ now()->format('d/m/Y') }}</div>
        </div>

        <div class="content">
            <div class="summary-box">
                <div class="summary-text">
                    {!! nl2br(e($config->intro_text)) !!}
                </div>
            </div>

            @foreach ($hires as $country => $companies)
                @foreach ($companies as $companyName => $employees)
                    <div class="country-group">
                        <div class="country-badge">
                            <span class="country-name">🌐 {{ strtoupper($country) }} › {{ $companyName }}</span>
                            <span class="count-pill">{{ $employees->count() }}
                                {{ $employees->count() === 1 ? 'INGRESO' : 'INGRESOS' }}</span>
                        </div>

                        <ul class="employee-list">
                            @foreach ($employees as $employee)
                                <li class="employee-item">
                                    <span class="emp-name">{{ $employee->nombre }}</span>
                                    <span class="dept-tag">
                                        Se incorpora al puesto de
                                        {{ \Illuminate\Support\Str::title($employee->puesto) }} al departamento de
                                        {{ $employee->centro_costo }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endforeach

            <div class="alert-box">
                <p class="alert-text">
                    ⚠️ <strong>Nota de control: </strong>{!! nl2br(e($config->closing_text)) !!}
                </p>
            </div>
        </div>

        <div class="footer">
            <span class="footer-brand">{{ $config->sign_off }}</span><br>
            Este es un reporte automático generado para el departamento de Recursos Humanos.
        </div>
    </div>
</body>

</html>
