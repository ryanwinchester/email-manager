<?php

namespace EmailManager\Http\Controllers;

use EmailManager\Subscriptions\ManagerFactory;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    private $managers;

    public function __construct(ManagerFactory $managerFactory)
    {
        $services = array_keys(config('email-manager.services'));
        $this->managers = $managerFactory->create($services);
    }

    public function status(Request $request)
    {
        $email = $request->get('email');

        return redirect()->route('email.status', ['email' => $email]);
    }

    public function email($email)
    {
        $services = $this->managers->map(function ($manager) use ($email) {
            return [
                'name' => $this->serviceNameFromClassName(get_class($manager)),
                'statuses' => $manager->status($email),
            ];
        });

        return view('status', compact('services', 'email'));
    }

    private function serviceNameFromClassName($class)
    {
        return ucfirst(str_replace('Subscriptions', '', class_basename($class)));
    }

    public function unsubscribe($email)
    {
        $this->managers->each(function ($manager) use ($email) {
            $manager->unsubscribe($email);
        });

        return back();
    }
}
