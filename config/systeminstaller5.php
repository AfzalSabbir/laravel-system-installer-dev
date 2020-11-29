<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application requirments
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */
   
    'requirments' => [
        /**
         * @param cond    : Supportable condition
         * @param v       : Supported version
         * @param comment : Comment if error occures
         * @param pass    : Always expacted true
         * 
         */
        'php' => [
            'cond'    => '>=',
            'v'       => '7.3',
            'comment' => 'Version required: ^7.3',
            'pass'    => version_compare(phpversion(), '7.3') != -1
        ],
        'laravel' => [
            'cond'    => '>=',
            'v'       => '8.12',
            'comment' => 'Version required: ^8.12',
            'pass'    => version_compare(app()->version(), '8.12') != -1
        ],
        'openssl' => [
            'cond'    => '>=',
            'v'       => '269488255',
            'pass'    => version_compare(OPENSSL_VERSION_NUMBER, 269488255) != -1
        ],
        'pdo' => [
            'cond'    => '==',
            'v'       => 'mysql',
            'pass'    => array_search('mysql', PDO::getAvailableDrivers()) !== false
        ],
        'mbstring' => [
            'cond'    => '==',
            'v'       => 'mbstring',
            'pass'    => extension_loaded('mbstring')
        ],
        'json' => [
            'cond'    => '==',
            'v'       => 'json',
            'pass'    => extension_loaded('json')
        ],
        'curl' => [
            'cond'    => '==',
            'v'       => 'curl',
            'pass'    => extension_loaded('curl')
        ],
        'imap' => [
            'cond'    => '==',
            'v'       => 'imap',
            'pass'    => extension_loaded('imap')
        ],
        'fileinfo' => [
            'cond'    => '==',
            'v'       => 'fileinfo',
            'pass'    => extension_loaded('fileinfo')
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Directories Check
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */
   
    'directories' => [
        'storage' => ['framework', 'logs'],
        'other'   => ['bootstrap/cache']
    ],

    /*
    |--------------------------------------------------------------------------
    | Application env setup
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */
   
    'setups' => [
        'env'         => [
            'APP_NAME'  => [
                'label' => 'App Name',
                'type'  => 'text',
                'attr'  => [
                    'required' => "true",
                    'minlength' => 5
                ],
                'value' => 'Laravel'
            ],
            'APP_ENV'   => [
                'label' => 'App Env',
                'type'  => 'text',
                'attr'  => [
                    'required' => "true"
                ],
                'value' => [
                    'local'       => 'local',
                    'production'  => 'production',
                    'development' => 'development',
                    'testing'     => 'testing',
                ]
            ],
            'APP_DEBUG' => [
                'label' => 'App Debug',
                'type'  => 'text',
                'attr'  => [
                    'required' => "true"
                ],
                'value' => [
                    'Yes' => "true",
                    'No'  => "false",
                ]
            ],
            'APP_URL'   => [
                'label' => 'App Url',
                'type'  => 'text',
                'attr'  => [
                    'required' => "true"
                ],
                'value' => 'http://localhost'
            ],
            'LOG_LEVEL' => [
                'label' => 'Log Level',
                'type'  => 'text',
                'attr'  => [
                    'required' => "true"
                ],
                'value' => [
                    'debug' => 'debug',
                    'info' => 'info',
                    'notice' => 'notice',
                    'warning' => 'warning',
                    'error' => 'error',
                    'critical' => 'critical',
                    'alert' => 'alert',
                    'emergency' => 'emergency'
                ]
            ],
        ],
        'database'    => [
            'DB_CONNECTION' => [
                'label' => 'DB Connection',
                'type'  => '',
                'attr'  => [],
                'value' => [
                    'MySQL' => 'mysql'
                ]
            ],
            'DB_HOST' => [
                'label' => 'DB Host',
                'type'  => 'text',
                'attr'  => [],
                'value' => '127.0.0.1'
            ],
            'DB_PORT' => [
                'label' => 'DB Port',
                'type'  => 'number',
                'attr'  => [],
                'value' => '3306'
            ],
            'DB_DATABASE' => [
                'label' => 'DB Database',
                'type'  => 'text',
                'attr'  => [],
                'value' => 'installer'
            ],
            'DB_USERNAME' => [
                'label' => 'DB Username',
                'type'  => 'text',
                'attr'  => [],
                'value' => 'root'
            ],
            'DB_PASSWORD' => [
                'label' => 'DB Password',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ]
        ],
        'driver'      => [
            'BROADCAST_DRIVER' => [
                'label' => 'Broadcast Driver',
                'type'  => '',
                'attr'  => [],
                'value' => [
                    'log' => 'log'
                ]
            ],
            'CACHE_DRIVER' => [
                'label' => 'Cache Driver',
                'type'  => 'text',
                'attr'  => [],
                'value' => [
                    'file' => 'file'
                ]
            ],
            'SESSION_DRIVER' => [
                'label' => 'Session Driver',
                'type'  => '',
                'attr'  => [],
                'value' => [
                    'file' => 'file'
                ]
            ],
            'SESSION_LIFETIME' => [
                'label' => 'Session Lifetime',
                'type'  => 'number',
                'attr'  => [],
                'value' => 120
            ]
        ],
        'mail'        => [
            'MAIL_MAILER' => [
                'label' => 'Mail Mailer',
                'type'  => '',
                'attr'  => [],
                'value' => [
                    'SMTP' => 'smtp',
                    'TLS'  => 'tls',
                    'SSL'  => 'ssl',
                ]
            ],
            'MAIL_HOST' => [
                'label' => 'Mail Host',
                'type'  => 'text',
                'attr'  => [],
                'value' => 'smtp.mailtrap.io'
            ],
            'MAIL_PORT' => [
                'label' => 'Mail Port',
                'type'  => 'number',
                'attr'  => [],
                'value' => '2525'
            ],
            'MAIL_USERNAME' => [
                'label' => 'Mail Username',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'MAIL_PASSWORD' => [
                'label' => 'Mail Password',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'MAIL_ENCRYPTION' => [
                'label' => 'Mail Encryption',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'MAIL_FROM_ADDRESS' => [
                'label' => 'Mail From Address',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            /*'MAIL_FROM_NAME' => [
                'label' => 'Mail From Name',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ]*/
        ],
        'radis'       => [
            'REDIS_HOST' => [
                'label' => 'Redis Host',
                'type'  => 'text',
                'attr'  => [],
                'value' => '127.0.0.1'
            ],
            'REDIS_PASSWORD' => [
                'label' => 'Redis Password',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'REDIS_PORT' => [
                'label' => 'Redis Port',
                'type'  => 'number',
                'attr'  => [],
                'value' => '6379'
            ]
        ],
        'pusher'      => [
            'PUSHER_APP_ID' => [
                'label' => 'Pusher App Id',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'PUSHER_APP_KEY' => [
                'label' => 'Pusher App Key',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'PUSHER_APP_SECRET' => [
                'label' => 'Pusher App Secret',
                'type'  => 'text',
                'attr'  => [],
                'value' => ''
            ],
            'PUSHER_APP_CLUSTER' => [
                'label' => 'Pusher App Cluster',
                'type'  => '',
                'attr'  => [],
                'value' => [
                    'mt1' => 'mt1',
                    'us2' => 'us2',
                    'us3' => 'us3',
                    'eu'  => 'eu',
                    'ap1' => 'ap1',
                    'ap2' => 'ap2',
                    'ap3' => 'ap3',
                    'ap4' => 'ap4',
                ]
            ]
        ],
    ],
];
