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

namespace App\Console\Commands\Secu;

use App\Repositories\Secu\SecuRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DestroyOutdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secu:destroy-outdated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy outdated SЁCU records.';

    /**
     * @var \App\Repositories\Secu\SecuRepository
     */
    private $secu;

    /**
     * Create a new command instance.
     *
     * @param \App\Repositories\Secu\SecuRepository $secu
     */
    public function __construct(SecuRepository $secu)
    {
        parent::__construct();

        $this->secu = $secu;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timestamp = Carbon::now()->subDays(30);
        $this->secu->olderThan($timestamp)->delete();
    }
}
