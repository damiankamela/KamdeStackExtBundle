<?php

namespace Kamde\StackExtBundle\Service\ApiClient;

interface ResponseInterface
{
    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @return bool
     */
    public function hasMore(): bool;

    /**
     * @return int
     */
    public function getQuotaMax(): int;

    /**
     * @return int
     */
    public function getQuotaRemaining(): int;
}