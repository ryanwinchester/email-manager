<?php

namespace EmailManager\Http\Controllers;

use Drewm\MailChimp;
use Fungku\HubSpot\HubSpotService;

class EmailController extends Controller
{
    /**
     * @var \Drewm\MailChimp
     */
    private $mailchimp;

    /**
     * @var \Fungku\HubSpot\HubSpotService
     */
    private $hubspot;

    public function __construct(MailChimp $mailchimp, HubSpotService $hubspot)
    {
        $this->mailchimp = $mailchimp;
        $this->hubspot = $hubspot;
    }

    public function status($email)
    {
        $lists = collect($this->mailchimp->call('lists/list')['data']);

        $mailchimp = $lists->reduce(function($subscriptions, $list) use ($email) {
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
                    'groupings' => [],
                ];

                if (isset($status['data'][0]['merges']['GROUPINGS'])) {
                    $subscription['groupings'] = array_reduce(
                        $status['data'][0]['merges']['GROUPINGS'][0]['groups'],
                        function ($carry, $grouping) {
                            if ($grouping['interested']) {
                                $carry[] = $grouping['name'];
                            }
                            return $carry;
                        },
                        []
                    );
                }

                $subscriptions[] = $subscription;
            }

            return $subscriptions;
        }, []);

        // $hubspotStatus->subscriptionStatuses : array
        // $hubspotStatus->subscribed : boolean
        $hubspot = $this->hubspot->email()->subscriptionStatus(env('HUBSPOT_PORTAL_ID'), $email);

        return view('status', compact('mailchimp', 'hubspot'));
    }
}
