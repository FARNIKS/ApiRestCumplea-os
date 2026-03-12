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
            margin-top: 25px;
            color: #444;
        }

        .phrase-box {
            background-color: #f4f7fa;
            border-top: 3px solid #0056b3;
            padding: 30px;
            margin: 35px 0;
            text-align: center;
            border-radius: 0 0 8px 8px;
        }

        .phrase-title {
            font-weight: bold;
            color: #0056b3;
            display: block;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .phrase-text {
            font-size: 1.3em;
            color: #333;
            font-style: italic;
            font-weight: 300;
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
        <!-- Banner Corporativo (Sugerencia: Usa una imagen de equipo o logo institucional) -->
        <img src="https://www.elorbe.la/images/cumpleanos.jpg" alt="OBGROUP Institucional" class="banner">

        <p class="intro-text">
            ¡Buen día, equipo de <strong>OBGROUP</strong>! <br><br>
            Hoy no registramos compañeros de cumpleaños en nuestras sucursales, pero aprovechamos este espacio para
            compartir un mensaje de valor con todos ustedes.
        </p>

        <!-- El corazón del correo: La Frase del Día -->
        <div class="phrase-box">
            <span class="phrase-title">Inspiración para hoy</span>
            <p class="phrase-text">"{{ $data['phrase'] }}"</p>
        </div>

        <p>¡Les deseamos una jornada llena de productividad y éxito!</p>

        <div class="footer">
            <p>Atentamente,<br>
                <strong>Departamento de Recursos Humanos</strong><br>
                &copy; {{ date('Y') }} OBGROUP
            </p>
        </div>
    </div>
</body>

</html>
