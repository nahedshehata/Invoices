<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{

    public function boot(): void{


    }
}
