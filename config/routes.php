<?php

return [
    'user/create' => 'user/create',
    'user/delete/([0-9]+)' => 'user/delete/$1',
    'user/update/([0-9]+)' => 'user/update/$1',
    'user/([0-9]+)' => 'user/view/$1',
    'user/sort=(.+)/page=([0-9]+)' => 'user/index/$1/$2',
    'user/sort=(.+)' => 'user/index/$1',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'user$' => 'user/index',
    '403' => 'user/403',
    '404' => 'user/404',
    '(.+)' => 'user/404',
    '' => 'user/login',
];

