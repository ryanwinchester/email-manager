<?php

namespace EmailManager\Subscriptions;

use Drewm\MailChimp;

class MailchimpSubscriptions implements SubscriptionManager
{
    /**
     * @var \Drewm\MailChimp
     */
    private $mailchimp;

    private $config;

    public function __construct(MailChimp $mailchimp, $config = [])
    {
        $this->mailchimp = $mailchimp;
        $this->config = $config ?: config('email-manager.services.mailchimp');
    }

    public function lists()
    {
        return collect($this->mailchimp->call('lists/list')['data']);
    }

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
                $subscription = [
                    'id' => $status['data'][0]['list_id'],
                    'name' => $status['data'][0]['list_name'],
                    'subscribed' => true,
                ];

                if (isset($status['data'][0]['merges']['GROUPINGS'])) {
                    $subscription['groupings'] = array_map(function ($grouping) {
                        return [
                            'name' => $grouping['name'],
                            'subscribed' => $grouping['interested'],
                        ];
                    }, $status['data'][0]['merges']['GROUPINGS'][0]['groups']);
                }

                return $subscription;
            }

            return [
                'id' => $list['id'],
                'name' => $list['name'],
                'subscribed' => false,
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