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

use App\Models\Secu;
use App\Observers\SecuObserver;
use App\Services\CryptService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository as AppConfigRepositoryInterface;
use Illuminate\Contracts\Foundation\Application as ApplicationInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRemoteCrypter();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerObservers();
    }

    private function registerObservers(): void
    {
        Secu::observe(SecuObserver::class);
    }

    protected function registerRemoteCrypter(): void
    {
        $this->app->singleton(
            CryptService::class,
            function (ApplicationInterface $application) {
                $appConfigRepository = $application->get(AppConfigRepositoryInterface::class);
                $crypterBaseUri = $appConfigRepository->get('hashing.remote_crypter.base_uri');

                return new CryptService(
                    $crypterBaseUri,
                    new Client([
                        'timeout' => 4,
                        'connect_timeout' => 2,
                    ])
                );
            }
        );
    }
}
