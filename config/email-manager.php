<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for email list services such
    | as Mailchimp, Hubspot, and many others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    'services' => [

        'mailchimp' => [
            'key' => env('MAILCHIMP_API_KEY', 'abc123abc123abc123abc123abc123-us1'),
        ],

//        'hubspot' => [
//            'key' => env('HUBSPOT_API_KEY', 'demo'),
//            'portal_id' => env('HUBSPOT_PORTAL_ID', '62515'),
//        ],

    ],

];