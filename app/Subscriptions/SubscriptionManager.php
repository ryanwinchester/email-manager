<?php

namespace EmailManager\Subscriptions;

interface SubscriptionManager
{
    public function lists();

    public function status($email);

    public function subscribe($email, $lists = []);

    public function unsubscribe($email, $lists = []);
}