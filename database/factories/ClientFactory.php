<?php

namespace Database\Factories;

use App\Domains\Auth\Models\User;
use App\Domains\Client\Enums\DocumentType;
use App\Domains\Client\Models\Client;
use App\Domains\Client\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;


class ClientFactory extends Factory
{
    protected $model = Client::class;
    public function definition(): array
    {
        /*Determinar el tipo de documento basándonos
         * en porcentajes (80% RUT, 20% PASSPORT)
         *fake()->boolean(80) devuelve verdadero el 80% de las veces*/
        $documentType = fake()->boolean(80) ? DocumentType::RUT : DocumentType::PASSPORT;

        //Generar el número de documento dependiendo del tipo seleccionado
        $documentNumber = match ($documentType) {
            DocumentType::RUT => $this->generateValidRut(), // Formato RUT chileno: XX.XXX.XXX-X
            DocumentType::PASSPORT => fake()->bothify('??######'), // Ejemplo Pasaporte: dos letras y 6 números (ej: AA123456)
        };
        return [
            'document_type' => $documentType->value,
            'document_number' => $documentNumber,
            'notes' => null,
            'secondary_phone' => fake()->numerify('9########'),
            'street' => fake()->streetName,
            'number' => fake()->numberBetween(1, 1500),
            'apartment' => fake()->optional(0.15)->numberBetween(1, 40),
            'commune_id' => fn() => Commune::query()->inRandomOrder()->value('id'),
            'user_id' => User::factory()->client(),
        ];
    }

    private function generateValidRut(): string
    {
        $number = fake()->numberBetween(5000000, 25000000);

        // Calcular dígito verificador (Algoritmo Módulo 11)
        $rutArr = array_reverse(str_split($number));
        $factor = 2;
        $sum = 0;
        foreach ($rutArr as $digit) {
            $sum += $digit * $factor;
            $factor = $factor == 7 ? 2 : $factor + 1;
        }
        $dv = 11 - ($sum % 11);
        $dvStr = match ($dv) {
            11 => '0',
            10 => 'K',
            default => (string)$dv
        };

        // Retorna formato estándar chileno: XX.XXX.XXX-X
        return number_format($number, 0, ',', '.') . '-' . $dvStr;
    }
}
