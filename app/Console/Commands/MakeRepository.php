<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    protected $signature = 'make:repository {name} {--model=}';
    protected $description = 'Create a new repository class';

    public function handle()
    {
        $name = $this->argument('name');
        $model = $this->option('model');

        if (!$model) {
            $this->error('You must specify a model using the --model option.');
            return;
        }

        $namespace = 'App\Repositories';
        $path = app_path("Repositories/{$name}.php");

        if (File::exists($path)) {
            $this->error('Repository already exists!');
            return;
        }

        $stub = File::get(base_path('stubs/repository.stub'));

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}'],
            [$namespace, $name, $model],
            $stub
        );

        File::ensureDirectoryExists(app_path('Repositories'));
        File::put($path, $stub);

        $this->info("Repository {$name} created successfully.");
    }
}
