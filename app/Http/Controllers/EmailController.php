<?php

namespace EmailManager\Http\Controllers;

use EmailManager\Events\EmailWasChanged;
use EmailManager\Events\EmailWasUnsubscribed;
use EmailManager\Events\NameWasChanged;
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

        event(new EmailWasChanged($email, $new_email, \Auth::user()));

        return redirect()->route('email.status', ['email' => $new_email])
            ->with('info', '<strong>Email change submitted.</strong> It might take a few minutes to show correctly.');
    }

    public function changeName(Request $request, $email)
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');

        $this->managers->each(function ($manager) use ($email, $first_name, $last_name) {
            $manager->changeName($email, $first_name, $last_name);
        });

        event(new NameWasChanged($email, $first_name, $last_name, \Auth::user()));

        return back()
            ->with('info', '<strong>Name change submitted.</strong> It might take a few minutes to show correctly.');
    }

    public function unsubscribe($email)
    {
        $this->managers->each(function ($manager) use ($email) {
            $manager->unsubscribe($email);
        });

        event(new EmailWasUnsubscribed($email, \Auth::user()));

        return back()
            ->with('info', '<strong>Email unsubscribed</strong> from all. It might take a few minutes to show correctly.');
    }
}
