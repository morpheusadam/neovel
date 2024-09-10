module
   composer require nwidart/laravel-modules
      php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
         php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="config"
            php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="stubs"
               
               "extra": {
       "laravel": {
           "dont-discover": []
       },
       "merge-plugin": {
           "include": [
               "Modules/*/composer.json"
           ]
       }
   }
   composer require laravel/sanctum
      php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"