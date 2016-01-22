<?php

namespace EmailManager\Events;

use EmailManager\Events\Event;
use EmailManager\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailWasChanged extends Event
{
    use SerializesModels;

    public $email;
    public $new_email;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct($email, $new_email, User $user)
    {
        $this->email = $email;
        $this->new_email = $new_email;
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
