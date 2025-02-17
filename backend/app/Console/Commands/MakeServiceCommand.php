<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services');
        
        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath);
        }

        $serviceTemplate = <<<EOT
<?php

namespace App\Services;

class {$name}
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
EOT;

        $filePath = $servicePath . "/{$name}.php";

        if (File::exists($filePath)) {
            $this->error('Service already exists!');
            return;
        }

        File::put($filePath, $serviceTemplate);
        $this->info('Service created successfully!');
    }
}
