<?php

namespace EmailManager\Listeners;

use EmailManager\Event;

class EmailEventListener
{
    public function onEmailWasChanged($event)
    {
        Event::create([
            'subject' => $event->email,
            'action' => 'changed',
            'field' => 'email',
            'old' => $event->email,
            'new' => $event->new_email,
            'user_id' => $event->user->id,
        ]);
    }

    public function onNameWasChanged($event)
    {
        Event::create([
            'subject' => $event->email,
            'action' => 'changed',
            'field' => 'name',
            'new' => $event->first_name.' '.$event->last_name,
            'user_id' => $event->user->id,
        ]);
    }

    public function onEmailWasUnsubscribed($event)
    {
        Event::create([
            'subject' => $event->email,
            'action' => 'unsubscribed',
            'field' => 'email',
            'new' => 'unsubscribed',
            'user_id' => $event->user->id,
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'EmailManager\Events\EmailWasChanged',
            'EmailManager\Listeners\EmailEventListener@onEmailWasChanged'
        );

        $events->listen(
            'EmailManager\Events\NameWasChanged',
            'EmailManager\Listeners\EmailEventListener@onNameWasChanged'
        );

        $events->listen(
            'EmailManager\Events\EmailWasUnsubscribed',
            'EmailManager\Listeners\EmailEventListener@onEmailWasUnsubscribed'
        );
    }
}
