<?php

namespace EmailManager\Subscriptions;

use Fungku\HubSpot\HubSpotService;

class HubspotSubscriptions implements SubscriptionManager
{
    /**
     * @var \Fungku\HubSpot\HubSpotService
     */
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
        $lists = $this->lists();
        $status = $this->hubspot->email()
            ->subscriptionStatus($this->config['portal_id'], $email)
            ->getData();

        $statuses = collect($status->subscriptionStatuses);

        return $lists->map(function ($list) use ($statuses) {
            $status = $statuses->where('id', $list->id)->first();
            return [
                'id' => $list->id,
                'name' => $list->name,
                'subscribed' => $status ? $status->subscribed : false,
            ];
        });
    }

    public function subscribe($email, $lists = [])
    {
        // TODO: Implement subscribe() method.
    }

    public function unsubscribe($email, $lists = [])
    {
        // TODO: Implement unsubscribe() method.
    }
}