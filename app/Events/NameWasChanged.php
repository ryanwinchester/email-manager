<?php

namespace EmailManager\Events;

use EmailManager\Events\Event;
use EmailManager\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NameWasChanged extends Event
{
    use SerializesModels;

    public $email;
    public $first_name;
    public $last_name;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($email, $first_name, $last_name, User $user)
    {
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
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
