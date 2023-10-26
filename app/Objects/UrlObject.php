<?php

namespace MvcPhpUrlShortner\Objects;

use DateTime;

class UrlObject
{
    private string $shortUrl;
    private string $originalUrl;
    private int $usedAmount;
    private DateTime $createdAt;


    public function __construct(string $short_url, string $original_url, int $usedAmount, DateTime $createdAt = null)
    {
        $this->shortUrl = $short_url;
        $this->originalUrl = $original_url;
        $this->usedAmount = $usedAmount;
        if ($createdAt) {
            $this->createdAt = $createdAt;
        }
    }

    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(string $shortUrl): void
    {
        $this->shortUrl = $shortUrl;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): void
    {
        $this->originalUrl = $originalUrl;
    }

    public function getUsedAmount(): int
    {
        return $this->usedAmount;
    }

    public function setUsedAmount(int $usedAmount): void
    {
        $this->usedAmount = $usedAmount;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}