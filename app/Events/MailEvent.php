<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MailEvent extends Event
{
    use SerializesModels;
    public $somevar;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($a, $b)
    {
        $this->somevar = $a+$b;
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
