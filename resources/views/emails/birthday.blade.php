<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #f0f0f0;
        }

        .banner {
            width: 100%;
            height: auto;
            border-radius: 4px;
            display: block;
        }

        .intro-text {
            font-size: 1.1em;
            margin-top: 20px;
        }

        .country-section {
            margin-top: 25px;
        }

        .company-header {
            color: #0056b3;
            font-size: 1.2em;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .employee-list {
            list-style: none;
            padding-left: 20px;
            margin: 0;
        }

        .employee-item {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .phrase-box {
            background-color: #fdf6e3;
            border-left: 5px solid #d3af37;
            padding: 20px;
            margin: 30px 0;
            font-style: italic;
        }

        .footer-text {
            font-size: 0.95em;
            color: #555;
        }

        .footer {
            font-size: 0.85em;
            color: #999;
            margin-top: 40px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Imagen Banner según tu estructura -->
        <img src="https://www.elorbe.la/images/cumpleanos.jpg" alt="Image birthday banner" class="banner">

        <p class="intro-text">
            ¡Feliz Cumpleaños de parte de <strong>OBGROUP</strong>! <br>
            Hoy celebramos a nuestros valiosos compañeros.
        </p>

        <!-- Iteración Jerárquica: País > Empresa > Empleado -->
        @foreach ($data['birthdays'] as $country => $companies)
            <div class="country-section">
                @foreach ($companies as $companyName => $employees)
                    <!-- Título Combinado: País + Empresa -->
                    <h3 class="company-header">📍 {{ $country }} {{ $companyName }}:</h3>
                    <ul class="employee-list">
                        @foreach ($employees as $employee)
                            <li class="employee-item">
                                🎂 {{ $employee->name }}
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        @endforeach

        <div class="footer-text">
            <p>Les deseamos un día lleno de alegría. ¡Que lo disfruten!</p>
            <p><strong>¡Detente un momento para leer esto...!</strong></p>
        </div>

        <!-- Sección de la Frase Motivacional del día (1-366) -->
        <div class="phrase-box">
            <p style="margin:0; color: #856404;">"{{ $data['phrase'] }}"</p>
        </div>

        <div class="footer">
            <p>Atentamente,<br>
                <strong>Departamento de Recursos Humanos</strong><br>
                &copy; {{ date('Y') }} OBGROUP
            </p>
        </div>
    </div>
</body>

</html>
