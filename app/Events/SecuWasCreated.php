<?php

/*
 * This file is part of SЁCU.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class SecuWasCreated.
 * @package App\Events
 */
class SecuWasCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var
     */
    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($secu)
    {
        $this->id = $secu->id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['secu-channel'];
    }
}
