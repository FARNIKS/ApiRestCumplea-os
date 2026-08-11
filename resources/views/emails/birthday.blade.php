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

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.05);
            border: 1px solid #e2e8f0;
        }

        .banner {
            width: 100%;
            height: auto;
            display: block;
        }

        .content {
            padding: 15px 30px 30px 30px;
        }

        .intro-text {
            font-size: 15.5px;
            color: #334155;
            margin-bottom: 25px;
        }

        .country-section {
            margin-top: 30px;
        }

        .company-group {
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.02);
        }

        .company-header {
            background-color: #f8fafc;
            padding: 14px 20px;
            margin: 0;
            color: #0f172a;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
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
            font-size: 15.5px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
        }

        .employee-item:last-child {
            border-bottom: none;
        }

        .closing-section {
            font-size: 15px;
            color: #475569;
            margin-top: 30px;
        }

        .phrase-box {
            background-color: #fffbeb;
            border-radius: 12px;
            padding: 22px;
            margin: 30px 0 5px 0;
            border: 1px solid #fef3c7;
            text-align: center;
        }

        .phrase-text {
            margin: 0;
            color: #b45309;
            font-size: 15px;
            font-style: italic;
            line-height: 1.5;
            font-weight: 500;
        }

        .footer {
            font-size: 12px;
            color: #64748b;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            background-color: #f8fafc;
            padding-bottom: 10px;
        }

        .footer strong {
            color: #334155;
        }
    </style>
</head>

<body style="background-color: transparent;">

    <!-- Preheader oculto para optimizar la entrega en la bandeja principal -->
    <div
        style="display: none; max-height: 0px; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; color: #fff;">
        Comunicado interno sobre los colaboradores que celebran su cumpleaños en Corporación OBGROUP.
    </div>

    <div class="container">
        <img src="{{ $config->banner_url }}" alt="Banner Cumpleaños OBGROUP" width="600"
            style="width: 100%; max-width: 600px; height: auto; display: block; border: 0;" class="banner">

        <div class="content">
            <p class="intro-text">
                {!! nl2br(e($config->intro_text)) !!}
            </p>

            @foreach ($data['birthdays'] as $country => $companies)
                <div class="country-section">
                    @foreach ($companies as $companyName => $employees)
                        <div class="company-group">

                            <h3 class="company-header">🥳 {{ strtoupper($country) }} › {{ $companyName }}</h3>

                            <ul class="employee-list">
                                @foreach ($employees as $employee)
                                    <li class="employee-item">
                                        <span style="margin-right: 8px;">🎂</span> {{ $employee->Nombre }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="closing-section">
                <p>{!! nl2br(e($config->main_body)) !!}</p>
                <p><strong>{{ $config->closing_text }}</strong></p>
            </div>

            <div class="phrase-box">
                <p class="phrase-text">"{{ $data['phrase'] }}"</p>
            </div>
        </div>

        <div class="footer">
            <p>Atentamente,<br>
                <strong>{{ $config->sign_off }}</strong><br>
                &copy; {{ date('Y') }} OBGROUP
            </p>
        </div>
    </div>
</body>

</html>
