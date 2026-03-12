<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #333;
            line-height: 1.5;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 25px;
            border: 2px solid #dc3545;
            background-color: #fff;
            border-radius: 8px;
        }

        .header {
            color: #dc3545;
            font-size: 1.4em;
            font-weight: bold;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .error-box {
            background-color: #fff5f5;
            border-left: 5px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            font-size: 0.85em;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.85em;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">⚠️ NOTIFICACIÓN DE ERROR DE SISTEMA</div>

        <p>Se ha detectado una anomalía durante la ejecución del proceso automatizado de cumpleaños para
            <strong>OBGROUP</strong>.</p>

        <div class="error-box">
            <p><span class="label">Mensaje de Error:</span><br>
                {{ $errorDetails['message'] }}</p>

            <p><span class="label">Fecha y Hora:</span><br>
                {{ $errorDetails['timestamp'] }}</p>

            <p><span class="label">Origen:</span><br>
                BirthdayService Quorum Validation</p>
        </div>

        <p><strong>Acción requerida:</strong> Favor de verificar la consistencia de los datos en SQL Server. El sistema
            requiere al menos 550 empleados activos para proceder.</p>

        <div class="footer">
            <p>Este es un reporte automático generado por el servidor.<br>
                Para más detalles, consulte los registros en: <code>storage/logs/laravel.log</code></p>
        </div>
    </div>
</body>

</html>
