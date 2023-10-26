<?php

namespace MvcPhpUrlShortner\Objects;

class UrlObject
{
    private string $short_url;
    private string $original_url;
    private int $usedAmount;

    public function __construct(string $short_url, string $original_url, int $usedAmount)
    {
        $this->short_url = $short_url;
        $this->original_url = $original_url;
        $this->usedAmount = $usedAmount;
    }

    public function getShortUrl(): string
    {
        return $this->short_url;
    }

    public function setShortUrl(string $short_url): void
    {
        $this->short_url = $short_url;
    }

    public function getOriginalUrl(): string
    {
        return $this->original_url;
    }

    public function setOriginalUrl(string $original_url): void
    {
        $this->original_url = $original_url;
    }

    public function getUsedAmount(): int
    {
        return $this->usedAmount;
    }

    public function setUsedAmount(int $usedAmount): void
    {
        $this->usedAmount = $usedAmount;
    }

}