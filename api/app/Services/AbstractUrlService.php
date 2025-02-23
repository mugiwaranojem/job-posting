<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\UrlVerification;

abstract class AbstractUrlService
{
    public function createUrlVerification(
        int $sourceId,
        array $params = []
    ): UrlVerification
    {
        return UrlVerification::create([
            'source_id' => $sourceId,
            'token' => Str::uuid(),
            'type' => $this->getType(),
            'params' => $params,
            'expiry' => $this->getExpiry(),
        ]);
    }

    protected function getExpiry(): \Carbon\CarbonInterface
    {
        return now()->addDays(3);
    }

    abstract public function generateUrl(string $token): ?string;
    abstract public function getType(): ?string;
}