<?php

namespace EmailManager\Http\Controllers;

use EmailManager\Subscriptions\ManagerFactory;

class EmailController extends Controller
{
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
                'name' => $this->serviceNameFromClassName(get_class($manager)),
                'statuses' => $manager->status($email),
            ];
        }, $managers);

        return view('status', compact('services', 'email'));
    }

    private function serviceNameFromClassName($class)
    {
        return ucfirst(str_replace('Subscriptions', '', class_basename($class)));
    }
}
