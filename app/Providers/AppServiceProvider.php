<?php

namespace App\Providers;

use App\Macro\QueryMacros;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });
            return $this;
        });

        // Builder::macro('whereLike', function ($attributes, string $searchTerm) {
        //     $this->where(function (Builder $query) use ($attributes, $searchTerm) {
        //         foreach (Arr::wrap($attributes) as $attribute) {
        //             $query->when(
        //                 str_contains($attribute, '.'),
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     [$relationName, $relationAttribute] = explode('.', $attribute);

        //                     $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
        //                         $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
        //                     });
        //                 },
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
        //                 }
        //             );
        //         }
        //     });

        //     return $this;
        // });

        Builder::mixin(new QueryMacros);
    }
}
