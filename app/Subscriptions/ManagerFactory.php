<?php

namespace EmailManager\Subscriptions;

class ManagerFactory
{
    public static function create($service)
    {
        if (is_array($service)) {
            return static::createMany($service);
        }

        return static::createOne($service);
    }

    public static function createMany($services)
    {
        return array_map(function ($service) {
            return static::createOne($service);
        }, $services);
    }

    public static function createOne($service)
    {
        $class = "\\EmailManager\\Subscriptions\\".ucfirst($service)."Subscriptions";

        return app($class);
    }
}
