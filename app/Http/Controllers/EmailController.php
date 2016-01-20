<?php

namespace EmailManager\Http\Controllers;

use EmailManager\Subscriptions\ManagerFactory;

class EmailController extends Controller
{
    /**
     * @var \EmailManager\Subscriptions\ManagerFactory
     */
    private $managerFactory;

    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
    }

    public function status($email)
    {
        $services = array_keys(config('email-manager.services'));
        $managers = $this->managerFactory->create($services);

        $services = array_map(function ($manager) use ($email) {
            return [
                'name' => ucfirst(str_replace('Subscriptions', '', class_basename(get_class($manager)))),
                'statuses' => $manager->status($email),
            ];
        }, $managers);

        return view('status', compact('services', 'email'));
    }
}
