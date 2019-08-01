<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:crud {name} {--web} {--api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command used to remove model, request, resource, controller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name =ucfirst($this->argument('name'));

        $model = app_path() . '\\' . $name . '.php';
        $request = app_path() . '\\Http\\Requests\\' . $name.'Request'. '.php';
        $resource = app_path() . '\\Http\\Resources\\' . $name.'Resource'. '.php';
        $controller = app_path() . '\\Http\\Controllers\\' . $name.'Controller'. '.php';


        unlink($model) or die("Couldn't delete file");
        unlink($request) or die("Couldn't delete file");
        unlink($resource) or die("Couldn't delete file");
        unlink($controller) or die("Couldn't delete file");
    }
}
