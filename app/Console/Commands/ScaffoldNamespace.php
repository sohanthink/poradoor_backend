<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScaffoldNamespace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scaffold {name} {--path=API/Admin} {--ver=v1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Model, Migration, Controller, Service, Repository, DTO, and Request';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->option('path'); // Defaults to API/Admin
        $ver  = $this->option('ver');  // Defaults to v1

        // Combine them for easy use
        $basePath = "{$path}/{$ver}";

        $this->info("🏗️  Scaffolding {$name} into {$basePath}...");

        $this->call('make:model', ['name' => $name, '-m' => true]);
        
        $this->call('make:controller', ['name' => "{$basePath}/{$name}Controller"]);
        
        $this->call('make:class', ['name' => "Services/{$basePath}/{$name}Service"]);
        
        $this->call('make:class', ['name' => "Repositories/{$basePath}/{$name}Repository"]);
        
        $this->call('make:class', ['name' => "DTOs/{$name}/{$name}DTO"]);

        $this->call('make:class', ['name' => "Response/{$basePath}/{$name}Responses"]);
        
        $this->call('make:resource', ['name' => "{$basePath}/{$name}Resource"]);
        
        $this->call('make:request', ['name' => "{$basePath}/{$name}Request"]);

        $this->table(['Component', 'Status'], [
            ['Model', 'Created'],
            ['Controller', "{$basePath}/{$name}Controller"],
            ['Service', "Services/{$basePath}/{$name}Service"],
        ]);
    }
}
