<?php

namespace Kamde\StackExtBundle\Service\ApiClient;

class Response implements ResponseInterface
{
    /** @var array */
    protected $items;

    /** @var bool */
    protected $hasMore;

    /** @var int */
    protected $quotaMax;

    /** @var int */
    protected $quotaRemaining;

    /**
     * @param array $body
     *
     */
    public function __construct(array $body)
    {
        $this->items = $body['items'] ?? null;
        $this->hasMore = $body['hasMore'] ?? null;
        $this->quotaMax = $body['quotaMax'] ?? null;
        $this->quotaRemaining = $body['quotaRemaining'] ?? null;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function hasMore(): bool
    {
        return $this->hasMore;
    }

    /**
     * @return int
     */
    public function getQuotaMax(): int
    {
        return $this->quotaMax;
    }

    /**
     * @return int
     */
    public function getQuotaRemaining(): int
    {
        return $this->quotaRemaining;
    }
}