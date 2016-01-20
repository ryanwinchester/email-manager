<?php

namespace EmailManager\Subscriptions;

use Fungku\HubSpot\HubSpotService;

class HubspotSubscriptions implements SubscriptionManager
{
    private $hubspot;
    private $config;

    public function __construct(HubSpotService $hubspot, $config = [])
    {
        $this->hubspot = $hubspot;
        $this->config = $config ?: config('email-manager.services.hubspot');
    }

    public function lists()
    {
        return collect($this->hubspot->email()
            ->subscriptions($this->config['portal_id'])
            ->subscriptionDefinitions);
    }

    public function status($email)
    {
        $status = $this->hubspot->email()
            ->subscriptionStatus($this->config['portal_id'], $email)
            ->getData();

        $subscribed = $status->subscribed;
        $statuses = collect($status->subscriptionStatuses);

        return $this->lists()->map(function ($list) use ($subscribed, $statuses) {
            $status = $statuses->where('id', $list->id)->first();
            return [
                'id' => $list->id,
                'name' => $list->name,
                'subscribed' => $status && $subscribed ? $status->subscribed : false,
            ];
        });
    }

    public function subscribe($email, $lists = [])
    {
        // TODO: Implement subscribe() method.
    }

    public function unsubscribe($email, $lists = [])
    {
        $this->hubspot->email()
            ->updateSubscription($this->config['portal_id'], $email, [
                'unsubscribeFromAll' => true,
            ]);
    }
}
