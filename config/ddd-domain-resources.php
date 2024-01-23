<?php

declare(strict_types=1);

// config for Alibori/LaravelDddDomainResources package
return [
    /**
     * Here goes the path to your DDD Domains folder.
     */
    'domains_path' => 'src',
    /**
     * Here goes all your desired DDD Domain Resources configuration.
     */
    'domains' => [
        'user' => [
            'name' => 'User',
            'namespace' => 'Src\\User',
        ],
    ]
];
