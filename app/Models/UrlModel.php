<?php

namespace MvcPhpUrlShortner\Models;

class UrlModel
{
    public string $short_url;
    public string $original_url;
    public int $usedAmount;


    public function __construct(string $short_url, string $original_url, int $usedAmount)
    {
        $this->short_url = $short_url;
        $this->original_url = $original_url;
        $this->usedAmount = $usedAmount;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

}