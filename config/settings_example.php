<?php

if (!array_key_exists('HTTP_HOST', $_SERVER)) {
    $_SERVER['HTTP_HOST'] = 'uselinkwizard.com';
}

return [
    'AD' => [
        'PLATFORM_NAME' => 'Link Wizard',
        'HEADING' => 'is a tool that can help link marketers make the best out of link management. You won\'t find another link management tool with this many features'
    ],
    'SECURE_PROTOCOL'   => 'https://',
    'COMPANY_NAME'      => 'Tier5 LLC',
    'APP_HOST'          => 'uselinkwizard.com',
    'APP_LOGIN_HOST'    => 'app.uselinkwizard.com',
    'APP_REDIRECT_HOST' => 'lnkw.co',
    'UPLOAD_IMG'        => 'public/uploads/images/',
    'HTTP_HOST'         => 'uselinkwizard.com',
    'SITE_LOGO'         => 'https://'.$_SERVER['HTTP_HOST'].'/public/images/logo.png',
    'FAVICON'           => 'https://'.$_SERVER['HTTP_HOST'].'/public/images/favicon.ico',
    'FB' => [
        'APP_ID' => '',
        'APP_SECRET' => ''
    ],
    'GL' => [
        'DATA_CLIENTID' => ''
    ],
    'VIEW' => [
        'SHORT_LINK'  =>  'Add Short Link',
        'CUSTOM_LINK' =>  'Add Wizard Link'
    ]
];
