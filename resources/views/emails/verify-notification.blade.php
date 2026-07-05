<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu cuenta</title>
    <style>
        /* Estilos generales para asegurar compatibilidad */
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-collapse: collapse;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f3f4f6;
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 550px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-top: 6px solid #0d9488; /* Verde esmeralda cl铆nico */
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .logo-area {
            margin-bottom: 25px;
        }
        .logo-icon {
            font-size: 42px;
            line-height: 1;
        }
        h1 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 12px 0;
        }
        p {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 24px 0;
        }
        .btn-container {
            margin: 30px 0;
        }
        .btn {
            background-color: #0d9488;
            color: #ffffff !important;
            display: inline-block;
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 6px rgba(13, 148, 136, 0.2);
        }
        .animal-divider {
            margin: 30px 0 15px 0;
            border-top: 1px solid #e5e7eb;
            padding-top: 25px;
        }
        .animal-icon {
            display: inline-block;
            margin: 0 8px;
            opacity: 0.8;
            vertical-align: middle;
        }
        .footer {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.5;
        }
        .alt-link {
            font-size: 12px;
            color: #9ca3af;
            word-break: break-all;
            margin-top: 20px;
        }
        .alt-link a {
            color: #0d9488;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <!-- Tarjeta Principal -->
                <table class="main-card" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content">

                            <!-- Logotipo M茅dico/Veterinario -->
                            <div class="logo-area">
                                <span class="logo-icon">馃惥</span>
                            </div>

                            <h1>隆Bienvenido a Animal Hospital!</h1>

                            <p>Hola, <strong>{{ $name }}</strong>. Gracias por registrarte en nuestra plataforma de gesti贸n veterinaria. Para garantizar la seguridad de tu cuenta y activar tus accesos, confirma tu correo electr贸nico pulsando el bot贸n de abajo:</p>

                            <!-- Bot贸n de Acci贸n Principal -->
                            <div class="btn-container">
                                <a href="{{ $url }}" class="btn" target="_blank">Confirmar Correo Electr贸nico</a>
                            </div>

                            <p style="margin-bottom: 0;">Si no has creado ninguna cuenta con nosotros, puedes ignorar o eliminar este mensaje con total seguridad.</p>

                            <!-- Divisor de Mascotas (Usa tablas para alineaci贸n segura) -->
                            <div class="animal-divider">
                                <table align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><img class="animal-icon" src="https://flaticon.com" width="28" alt="Gato"></td>
                                        <td><img class="animal-icon" src="https://flaticon.com" width="28" alt="Perro"></td>
                                        <td><img class="animal-icon" src="https://flaticon.com" width="28" alt="Mascota"></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Pie de p谩gina de la tarjeta -->
                            <div class="footer">
                                <strong>Animal Hospital API</strong><br>
                                Sistema Inteligente de Gesti贸n Veterinaria y Cuidado Animal
                            </div>

                            <!-- Enlace alternativo por si falla el bot贸n -->
                            <div class="alt-link">
                                Si tienes problemas con el bot贸n, copia este enlace en tu navegador:<br>
                                <a href="{{ $url }}">{{ $url }}</a>
                            </div>

                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
