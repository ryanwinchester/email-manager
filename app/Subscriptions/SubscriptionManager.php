<?php

namespace EmailManager\Subscriptions;

interface SubscriptionManager
{
    /**
     * Get all of the mailing lists.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists();

    /**
     * Get the subscription status of an email address for all the lists.
     *
     * @param string $email
     * @return \Illuminate\Support\Collection
     */
    public function status($email);

    /**
     * Subscribe an email address to any number of lists.
     *
     * @param string $email
     * @param array $lists
     */
    public function subscribe($email, $lists = []);

    /**
     * Unsubscribe an email address from any number of lists.
     *
     * @param string $email
     * @param array $lists
     */
    public function unsubscribe($email, $lists = []);

    /**
     * Change a subscriber's email address.
     *
     * @param string $email
     * @param string $new_email
     */
    public function changeEmail($email, $new_email);

    /**
     * Change a subscriber's name.
     *
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     */
    public function changeName($email, $first_name, $last_name);
}
