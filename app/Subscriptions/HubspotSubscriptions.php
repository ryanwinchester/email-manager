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

    /**
     * Get all of the mailing lists.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        return collect($this->hubspot->email()
            ->subscriptions($this->config['portal_id'])
            ->subscriptionDefinitions);
    }

    /**
     * Get the subscription status of an email address for all the lists.
     *
     * @param string $email
     * @return \Illuminate\Support\Collection
     */
    public function status($email)
    {
        $status = $this->hubspot->email()
            ->subscriptionStatus($this->config['portal_id'], $email)
            ->getData();

        $subscribed = $status->subscribed;
        $statuses = collect($status->subscriptionStatuses);

        return $this->lists()->map(function ($list) use ($subscribed, $statuses) {
            $status = $statuses->where('id', $list->id)->first();
            if (!$subscribed) {
                $subscribed = -1;
            } elseif (!$status) {
                $subscribed = 0;
            } else {
                $subscribed = $status->subscribed ? 1 : -1;
            }
            return [
                'id' => $list->id,
                'name' => $list->name,
                'subscribed' => $subscribed,
                'names' => ['first_name' => null, 'last_name' => null],
            ];
        });
    }

    /**
     * Subscribe an email address to any number of lists.
     *
     * @param string $email
     * @param array $lists
     */
    public function subscribe($email, $lists = [])
    {
        // TODO: Implement subscribe() method.
    }

    /**
     * Unsubscribe an email address from any number of lists.
     *
     * @param string $email
     * @param array $lists
     */
    public function unsubscribe($email, $lists = [])
    {
        $this->hubspot->email()
            ->updateSubscription($this->config['portal_id'], $email, [
                'unsubscribeFromAll' => true,
            ]);
    }

    /**
     * Change a subscriber's email address.
     *
     * @param string $email
     * @param string $new_email
     */
    public function changeEmail($email, $new_email)
    {
        $contact = $this->hubspot->contacts()->getByEmail($email);

        if ($contact->getStatusCode() != 404) {
            $this->hubspot->contacts()->update($contact->vid, [
                [
                    'property' => 'email',
                    'value' => $new_email,
                ],
            ]);
        }
    }

    /**
     * Change a subscriber's name.
     *
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     */
    public function changeName($email, $first_name, $last_name)
    {
        $contact = $this->hubspot->contacts()->getByEmail($email);

        if ($contact->getStatusCode() != 404) {
            $this->hubspot->contacts()->update($contact->vid, [
                [
                    'property' => 'firstname',
                    'value' => $first_name,
                ],
                [
                    'property' => 'lastname',
                    'value' => $last_name,
                ],
            ]);
        }
    }
}
