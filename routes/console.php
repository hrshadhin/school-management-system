<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('fresh-install {--d|with-data : Seed demo data}', function () {
    $storageLinkPath = public_path('storage');
    if(is_link($storageLinkPath)){
        unlink($storageLinkPath);
    }
    $this->call('storage:link');
    $this->call('key:generate', ['--ansi' => true]);

    $this->call('migrate:fresh', ['--seed' => true]);
    if ($this->option('with-data')) {
        $this->comment('Seeding demo data....');
        $this->call('db:seed', ['--class' => 'DemoSiteDataSeeder']);
        $this->call('db:seed', ['--class' => 'DemoAppDataSeeder']);
    }

    //clear cache
    $this->call('cache:all-clear');
    $this->comment('Setup complete!');
})->describe('Setup fresh copy of CloudSchool with or without demo data.');

//clear all caches
Artisan::command('cache:all-clear}', function () {
    //clear cache
    $this->comment('Clearing all type of caches...');
    $this->call('view:clear');
    $this->call('route:clear');
    $this->call('config:clear');
    $this->call('cache:clear');
})->describe('Clear all type of caches like view,route,config,data');