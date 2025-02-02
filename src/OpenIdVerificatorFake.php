<?php

declare(strict_types=1);

namespace Stackkit\LaravelGoogleCloudTasksQueue;

use Google\Auth\AccessToken;

class OpenIdVerificatorFake
{
    public function verify(?string $token, array $config): void
    {
        if (!$token) {
            return;
        }

        (new AccessToken())->verify(
            $token,
            [
                'audience' => hash_hmac('sha256', app('queue')->getHandler(), config('app.key')),
                'throwException' => true,
                'certsLocation' => __DIR__ . '/../tests/Support/self-signed-public-key-as-jwk.json',
            ]
        );
    }
}
