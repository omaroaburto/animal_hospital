<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Email verificado</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            width: 600px;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .success-icon {
            font-size: 50px;
            color: #22c55e;
        }

        h1 {
            margin: 10px 0;
            color: #1f2937;
        }

        p {
            color: #6b7280;
        }

        .animals {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
        }

        .animal {
            width: 120px;
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .animal:hover {
            transform: scale(1.1);
        }

        .badge {
            background: #ecfdf5;
            padding: 10px;
            border-radius: 12px;
            margin-top: 20px;
            color: #065f46;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            font-size: 13px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="success-icon">✔</div>

    <h1>¡Email verificado correctamente!</h1>

    <p>
        Hola {{ $user->name ?? 'usuario' }}, tu cuenta ya está activa.
    </p>

    <div class="badge">
        Email: {{ $user->email ?? $email ?? 'no disponible' }}
    </div>

    <div class="animals">
        <img class="animal" src="https://cdn-icons-png.flaticon.com/512/616/616430.png" alt="gato">
        <img class="animal" src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="perro">
        <img class="animal" src="https://cdn-icons-png.flaticon.com/512/1998/1998610.png" alt="cerdo">
    </div>

    <p>Ya puedes volver a la aplicación y comenzar a usar el sistema.</p>

    <div class="footer">
        AnimalHospital API • Sistema de gestión veterinaria
    </div>

</div>

</body>
</html>
