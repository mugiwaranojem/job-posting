<?php

namespace App\Services;

use App\Models\UrlVerification;

class JobSpamUrlService extends AbstractUrlService
{
    public const URL_TYPE = 'EMAIL_SPAM';

    public function generateUrl(string $token): ?string
    {
        $verification = UrlVerification::where('token', $token)
            ->where('expiry', '>', now())->first();

        if (!$verification) {
            return null;
        }

        return url(sprintf(
            '/jobs/%s/spam',
            $verification->token
        ));
    }

    public function getType(): ?string
    {
        return self::URL_TYPE;
    }

    protected function getExpiry(): \Carbon\CarbonInterface
    {
        return now()->addDays(5);
    }
}