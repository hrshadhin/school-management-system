<?php 

namespace SMS\Composers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function register()  
    {  
        $this->app->view->composer(
            "layouts.master",
            "SMS\Composers\MasterComposer"
        );  
    }

}  