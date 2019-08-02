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
        echo "Deleting ...";

        if($this->argument('name')):
            
            $name =ucfirst($this->argument('name'));

            $model = app_path() . '\\' . $name . '.php';
            $request = app_path() . '\\Http\\Requests\\' . $name.'Request'. '.php';
            $resource = app_path() . '\\Http\\Resources\\' . $name.'Resource'. '.php';
            $controller = app_path() . '\\Http\\Controllers\\' . $name.'Controller'. '.php';
            $apicontroller = app_path() . '\\Http\\Controllers\\API\\' . $name.'Controller'. '.php';


            if(\file_exists($model)) {unlink($model);}
            if(\file_exists($request)) {unlink($request);}
            if(\file_exists($resource)) {unlink($resource);}
            if(\file_exists($controller)) {unlink($controller);}
            if(\file_exists($apicontroller)) {unlink($apicontroller);}
            // unlink($request) or die("Couldn't delete file");
            // unlink($resource) or die("Couldn't delete file");
            // unlink($controller) or die("Couldn't delete file");
            // unlink($apicontroller) or die("Couldn't delete file");

            if ($files = scandir(base_path().'/database/migrations')) { // here add your directory
                foreach ($files as $file) {
                    if (preg_match( '/create_'. \str_plural($this->argument('name')) . '/i' , $file)) {
                        unlink( base_path().'/database/migrations/'. $file ) or die("Couldn't delete file");
                    }
                }
            }

            //remove routes in web.php
            $web = base_path('').'/routes/web.php';
            $webcontent = file_get_contents($web);
            $webreplace = "
Route::group(['prefix' => '".strtolower(str_plural($name))."'], function () {
    Route::get('/', '".$name."Controller@index');                               /* show all */
    Route::get('/create', '".$name."Controller@create');                        /* create page */
    Route::post('/', '".$name."Controller@store');                              /* store new data    */
    Route::get('/{".strtolower($name)."}', '".$name."Controller@show');         /* get data by id or ... */
    Route::get('/{".strtolower($name)."}/edit', '".$name."Controller@edit');    /* get data by id and show on edit page ... */
    Route::patch('/{".strtolower($name)."}', '".$name."Controller@update');     /* update by id ... */
    Route::delete('/{".strtolower($name)."}', '".$name."Controller@delete');    /* delete by id ... */
});
            ";
            $webcontent = str_replace($webreplace, "", $webcontent);
            file_put_contents($web, $webcontent, LOCK_EX);

            //remove routes in api.php
            $api = base_path('').'/routes/api.php';
            $apicontent = file_get_contents($api);
            $apireplace = "
Route::group(['prefix' => '".strtolower(str_plural($name))."'], function () {
    Route::get('/', 'API\\".$name."Controller@index');                              /* show all */
    Route::post('/', 'API\\".$name."Controller@store');                             /* store new data    */
    Route::get('/{".strtolower($name)."}', 'API\\".$name."Controller@show');        /* get data by id or ... */
    Route::patch('/{".strtolower($name)."}', 'API\\".$name."Controller@update');    /* update by id ... */
    Route::delete('/{".strtolower($name)."}', 'API\\".$name."Controller@delete');   /* delete by id ... */
});
            ";
            $apicontent = str_replace($apireplace, "", $apicontent);
            file_put_contents($api, $apicontent, LOCK_EX);

        endif;

        echo "\nCompleted!";
    }
}
