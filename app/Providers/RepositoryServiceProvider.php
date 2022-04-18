<?php

declare(strict_types=1);

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

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->secuRepository();
    }

    private function secuRepository(): void
    {
        $this->app->bind(
            \App\Repositories\Secu\SecuRepository::class,
            \App\Repositories\Secu\SecuRepositoryEloquent::class
        );
    }
}
