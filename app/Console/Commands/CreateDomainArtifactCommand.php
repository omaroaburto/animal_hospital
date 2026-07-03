<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateDomainArtifactCommand extends Command
{
    protected $signature = 'make:domain
                            {domain : El nombre del dominio (ej. Invoice)}
                            {type : El tipo de artefacto (model, factory, controller, policy, request, resource, collection, enum, middleware, notification, action, service)}
                            {name : El nombre del elemento (ej. CreateInvoiceRequest)}';

    protected $description = 'Genera cualquier tipo de artefacto dentro de un dominio específico o bases de datos si es factory';

    protected array $artifactMap = [
        'model'        => ['folder' => 'Models', 'suffix' => ''],
        'factory'      => ['folder' => 'factories', 'suffix' => 'Factory'], // Carpeta tradicional fuera de app
        'controller'   => ['folder' => 'Controllers', 'suffix' => 'Controller'],
        'policy'       => ['folder' => 'Policies', 'suffix' => 'Policy'],
        'request'      => ['folder' => 'Requests', 'suffix' => 'Request'],
        'resource'     => ['folder' => 'Resources', 'suffix' => 'Resource'],
        'collection'   => ['folder' => 'Resources', 'suffix' => 'Collection'],
        'enum'         => ['folder' => 'Enums', 'suffix' => ''],
        'middleware'   => ['folder' => 'Middlewares', 'suffix' => ''],
        'notification' => ['folder' => 'Notifications', 'suffix' => 'Notification'],
        'action'       => ['folder' => 'Actions', 'suffix' => 'Action'],
        'service'      => ['folder' => 'Services', 'suffix' => 'Service'],
    ];

    public function handle()
    {
        $domain = ucfirst($this->argument('domain'));
        $type = strtolower($this->argument('type'));
        $name = ucfirst($this->argument('name'));

        if (!array_key_exists($type, $this->artifactMap)) {
            $this->error("Tipo de artefacto no válido. Modos válidos: " . implode(', ', array_keys($this->artifactMap)));
            return Command::FAILURE;
        }

        $config = $this->artifactMap[$type];

        if ($config['suffix'] && !Str::endsWith($name, $config['suffix'])) {
            $name .= $config['suffix'];
        }

        $folder = $config['folder'];

        // Determinar ruta según el tipo de archivo
        if ($type === 'factory') {
            $directoryPath = base_path("database/factories");
            $namespace = "Database\\Factories";
        } else {
            $directoryPath = app_path("domains/{$domain}/{$folder}");
            $namespace = "App\\domains\\{$domain}\\{$folder}";
        }

        $filePath = "{$directoryPath}/{$name}.php";

        if (!File::isDirectory($directoryPath)) {
            File::makeDirectory($directoryPath, 0755, true);
        }

        if (File::exists($filePath)) {
            $this->error("¡El archivo {$name}.php ya existe en la ruta destino!");
            return Command::FAILURE;
        }

        $stub = $this->getStubContent($type, $namespace, $name, $domain);

        File::put($filePath, $stub);

        // Limpiar ruta para mostrar en consola de forma amigable
        $displayPath = $type === 'factory' ? "database/factories/{$name}.php" : "app/domains/{$domain}/{$folder}/{$name}.php";
        $this->info("¡Creado con éxito!: {$displayPath}");
        return Command::SUCCESS;
    }

    protected function getStubContent(string $type, string $namespace, string $name, string $domain = ''): string
    {
        $basePhp = "<?php\n\nnamespace {$namespace};\n\n";
        $modelName = $domain ?: 'Model';

        return match ($type) {
            'model' => $basePhp . "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Database\Eloquent\Factories\Factory;\nuse Database\\Factories\\{$name}Factory;\n\nclass {$name} extends Model\n{\n    use HasFactory;\n\n    protected \$fillable = [\n        //\n    ];\n\n    protected static function newFactory(): Factory\n    {\n        return {$name}Factory::new();\n    }\n}",

            'factory' => "<?php\n\nnamespace Database\\Factories;\n\nuse Illuminate\Database\Eloquent\Factories\Factory;\nuse App\\domains\\{$domain}\\Models\\" . Str::replaceLast('Factory', '', $name) . ";\n\nclass {$name} extends Factory\n{\n    protected \$model = " . Str::replaceLast('Factory', '', $name) . "::class;\n\n    public function definition(): array\n    {\n        return [\n            //\n        ];\n    }\n}",

            'controller' => $basePhp . "use App\Http\Controllers\Controller;\nuse Illuminate\Http\Request;\nuse Illuminate\Http\Response;\n\nclass {$name} extends Controller\n{\n    public function index() { // }\n    public function store(Request \$request) { // }\n    public function show(string \$id) { // }\n    public function update(Request \$request, string \$id) { // }\n    public function destroy(string \$id) { // }\n}",

            'policy' => $basePhp . "use App\Models\User;\nuse App\\domains\\{$domain}\\Models\\{$modelName};\nuse Illuminate\Auth\Access\HandlesAuthorization;\n\nclass {$name}\n{\n    use HandlesAuthorization;\n    public function viewAny(User \$user): bool { return false; }\n    public function view(User \$user, {$modelName} \$" . lcfirst($modelName) . "): bool { return false; }\n    public function create(User \$user): bool { return false; }\n    public function update(User \$user, {$modelName} \$" . lcfirst($modelName) . "): bool { return false; }\n    public function delete(User \$user, {$modelName} \$" . lcfirst($modelName) . "): bool { return false; }\n    public function restore(User \$user, {$modelName} \$" . lcfirst($modelName) . "): bool { return false; }\n    public function forceDelete(User \$user, {$modelName} \$" . lcfirst($modelName) . "): bool { return false; }\n}",

            'request' => $basePhp . "use App\Http\Requests\ApiFormRequest;\n\nclass {$name} extends ApiFormRequest\n{\n    public function authorize(): bool { return true; }\n    public function rules(): array { return []; }\n    public function messages(): array { return []; }\n}",

            'resource' => $basePhp . "use Illuminate\Http\Request;\nuse Illuminate\Http\Resources\Json\JsonResource;\n\nclass {$name} extends JsonResource\n{\n    public function toArray(Request \$request): array { return parent::toArray(\$request); }\n}",

            'collection' => $basePhp . "use Illuminate\Http\Request;\nuse Illuminate\Http\Resources\Json\ResourceCollection;\n\nclass {$name} extends ResourceCollection\n{\n    public function toArray(Request \$request): array { return parent::toArray(\$request); }\n}",

            'enum' => $basePhp . "enum {$name}: string\n{\n    // case PENDING = 'pending';\n}",

            'middleware' => $basePhp . "use Closure;\nuse Illuminate\Http\Request;\nuse Symfony\Component\HttpFoundation\Response;\n\nclass {$name}\n{\n    public function handle(Request \$request, Closure \$next): Response { return \$next(\$request); }\n}",

            'notification' => $basePhp . "use Illuminate\Bus\Queueable;\nuse Illuminate\Notifications\Notification;\n\nclass {$name} extends Notification\n{\n    use Queueable;\n    public function __construct() { // }\n    public function via(\$notifiable): array { return ['mail']; }\n}",

            'action' => $basePhp . "class {$name}\n{\n    public function __invoke() {\n}\n}",

            'service' => $basePhp . "class {$name}\n{\n    //\n}"
        };
    }
}
