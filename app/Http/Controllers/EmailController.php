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

    public function email(Request $request)
    {
        $email = $request->get('email');

        return redirect()->route('email.status', ['email' => $email]);
    }

    public function status($email)
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

    public function change(Request $request, $email)
    {
        $new_email = $request->get('new_email');

        $this->managers->each(function ($manager) use ($email, $new_email) {
            $manager->changeEmail($email, $new_email);
        });

        return redirect()->route('email.status', ['email' => $new_email])
            ->with('warning', '<strong>Email change submitted.</strong> It might take a few minutes to show correctly.');
    }

    public function unsubscribe($email)
    {
        $this->managers->each(function ($manager) use ($email) {
            $manager->unsubscribe($email);
        });

        return back()
            ->with('warning', '<strong>Email unsubscribed</strong> from all. It might take a few minutes to show correctly.');
    }
}
