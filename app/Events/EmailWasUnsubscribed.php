<?php

namespace EmailManager\Events;

use EmailManager\Events\Event;
use EmailManager\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailWasUnsubscribed extends Event
{
    use SerializesModels;

    public $email;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($email, User $user)
    {
        $this->email = $email;
        $this->user = $user;
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
