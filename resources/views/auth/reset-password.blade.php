<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña | Animal Hospital</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body{
            background: linear-gradient(135deg,#e0f2fe,#ecfeff,#f0fdf4);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-md">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- Cabecera -->
        <div class="bg-emerald-600 p-8 text-center text-white">

            <div class="text-6xl mb-3">
                🐾
            </div>

            <h1 class="text-3xl font-bold">
                Animal Hospital
            </h1>

            <p class="mt-2 text-emerald-100">
                Restablecimiento de contraseña
            </p>

        </div>

        <!-- Contenido -->
        <div class="p-8">

            <div class="mb-8">

                <h2 class="text-xl font-semibold text-gray-800">
                    ¡Hola!
                </h2>

                <p class="text-gray-600 mt-2 leading-relaxed">
                    Ingresa una nueva contraseña para acceder nuevamente a tu cuenta.
                    Por seguridad, este enlace solo puede utilizarse una vez.
                </p>

            </div>

            <form
                method="POST"
                action="{{ route('password.update') }}"
                class="space-y-6"
            >
                @csrf

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >

                <input
                    type="hidden"
                    name="email"
                    value="{{ $email }}"
                >

                <!-- Nueva contraseña -->
                <div>

                    <label
                        class="block mb-2 text-sm font-semibold text-gray-700"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        autofocus
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        placeholder="••••••••"
                    >

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- Confirmación -->
                <div>

                    <label
                        class="block mb-2 text-sm font-semibold text-gray-700"
                    >
                        Confirmar contraseña
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                        placeholder="••••••••"
                    >

                </div>

                <!-- Botón -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-emerald-600 hover:bg-emerald-700 transition text-white font-semibold py-3"
                >
                    Restablecer contraseña
                </button>

            </form>

            <div class="mt-8 rounded-xl bg-emerald-50 border border-emerald-100 p-4">

                <div class="flex items-start gap-3">

                    <div class="text-2xl">
                        🩺
                    </div>

                    <div>

                        <p class="font-semibold text-emerald-700">
                            Recomendación de seguridad
                        </p>

                        <p class="text-sm text-gray-600 mt-1">
                            Utiliza una contraseña única, con al menos 8 caracteres,
                            combinando letras mayúsculas, minúsculas, números y símbolos.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="text-center mt-6 text-gray-500 text-sm">

        © {{ date('Y') }} Animal Hospital · Cuidamos a quienes más quieres ❤️🐶🐱

    </div>

</div>

</body>
</html>
