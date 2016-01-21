<?php

namespace EmailManager\Subscriptions;

use Drewm\MailChimp;

class MailchimpSubscriptions implements SubscriptionManager
{
    private $mailchimp;
    private $config;

    public function __construct(MailChimp $mailchimp, $config = [])
    {
        $this->mailchimp = $mailchimp;
        $this->config = $config ?: config('email-manager.services.mailchimp');
    }

    /**
     * Get all of the mailing lists.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        return collect($this->mailchimp->call('lists/list')['data']);
    }

    /**
     * Get the subscription status of an email address for all the lists.
     *
     * @param string $email
     * @return \Illuminate\Support\Collection
     */
    public function status($email)
    {
        return $this->lists()->map(function($list) use ($email) {
            $status = $this->mailchimp->call('lists/member-info', [
                'id' => $list['id'],
                'emails' => [
                    ['email' => $email]
                ],
            ]);

            if ($status['success_count'] > 0) {
                $subscribed = $status['data'][0]['status'] == 'subscribed';
                $subscription = [
                    'id' => $status['data'][0]['list_id'],
                    'name' => $status['data'][0]['list_name'],
                    'subscribed' => $subscribed ? 1 : -1,
                ];

                if (isset($status['data'][0]['merges']['GROUPINGS'])) {
                    $subscription['groupings'] = array_map(function ($grouping) use ($subscribed) {
                        return [
                            'name' => $grouping['name'],
                            'subscribed' => $subscribed ? $grouping['interested'] : false,
                        ];
                    }, $status['data'][0]['merges']['GROUPINGS'][0]['groups']);
                }

                return $subscription;
            }

            return [
                'id' => $list['id'],
                'name' => $list['name'],
                'subscribed' => 0,
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
        if (empty($lists)) {
            $lists = $this->lists();
        } else {
            $lists = collect((array) $lists);
        }

        $lists->each(function ($list) use ($email) {
            $unsubscribe = $this->mailchimp->call('lists/unsubscribe', [
                'id' => $list['id'],
                'email' => ['email' => $email],
            ]);
        });
    }

    /**
     * Change a subscriber's email address.
     *
     * @param string $email
     * @param string $new_email
     */
    public function changeEmail($email, $new_email)
    {
        $this->lists()->each(function ($list) use ($email, $new_email) {
            $this->mailchimp->call('lists/update-member', [
                'id' => $list['id'],
                'email' => ['email' => $email],
                'merge_vars' => [
                    'new-email' => $new_email,
                ],
            ]);
        });
    }
}
