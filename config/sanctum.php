<?php

return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf('%s%s', 'localhost', env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''))),
    'guard' => ['web'],
    'expiration' => 525600,
    'token_prefix' => 'np_',
];
