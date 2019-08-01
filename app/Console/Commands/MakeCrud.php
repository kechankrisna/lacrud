<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name} {--web} {--api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be used to make bread for browse, read, edit, add, delete..';

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
        if($this->argument('name')):
            
            $name =ucfirst($this->argument('name'));
            Artisan::call("make:model $name --migration --controller --resource");
            Artisan::call("make:request $name". "Request");
            Artisan::call("make:resource $name". "Resource");

            if( $this->option('web') ){
                $web = base_path('').'/routes/web.php';
                $webcontent = file_get_contents($web);
                $webcontent .= "
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
                file_put_contents($web, $webcontent, LOCK_EX);
            }

            if( $this->option('api') ){
                Artisan::call("make:controller API/".$name."Controller --api");
                
                $api = base_path('').'/routes/api.php';
                $apicontent = file_get_contents($api);
                $apicontent .= "
Route::group(['prefix' => '".strtolower(str_plural($name))."'], function () {
    Route::get('/', 'API\\".$name."Controller@index');                              /* show all */
    Route::post('/', 'API\\".$name."Controller@store');                             /* store new data    */
    Route::get('/{".strtolower($name)."}', 'API\\".$name."Controller@show');        /* get data by id or ... */
    Route::patch('/{".strtolower($name)."}', 'API\\".$name."Controller@update');    /* update by id ... */
    Route::delete('/{".strtolower($name)."}', 'API\\".$name."Controller@delete');   /* delete by id ... */
});
            ";
                file_put_contents($api, $apicontent, LOCK_EX);
            }

        endif;
    }
}
