<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(121);

        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::after(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });

        Validator::extend('stock', function ($attribute, $value, $parameters, $validator) {
            $product = Product::find($validator->getData()['item']['product_id']);

            
            if ($value > $product->instock()) {
                $validator->errors()->add($attribute, 'The provided quantity exceeds the stock quantity.');
                return false;
            }
            return true;
        });
    }
}
