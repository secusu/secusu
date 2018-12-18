<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <open@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->secuRepository();
    }

    private function secuRepository()
    {
        $this->app->bind(
            \App\Repositories\Secu\SecuRepository::class,
            \App\Repositories\Secu\SecuRepositoryEloquent::class
        );
    }
}
