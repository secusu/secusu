<?php

/*
 * This file is part of Sёcu.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Console\Commands\Secu;

use App\Models\Secu;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class CleanOutdated.
 * @package App\Console\Commands\Secu
 */
class CleanOutdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secu:clean-outdated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean outdated Sёcu records';

    /**
     * @var Secu
     */
    private $secu;

    /**
     * Create a new command instance.
     *
     * @param Secu $secu
     */
    public function __construct(Secu $secu)
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
        $date = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        $this->secu->olderThan($date)->delete();
    }
}
