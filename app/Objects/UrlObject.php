<?php

namespace MvcPhpUrlShortner\Objects;

use DateTime;

class UrlObject
{
    private int $id;
    private string $shortUrl;
    private string $originalUrl;
    private int $usedAmount;
    private DateTime $createdAt;


    public function __construct(string $shortUrl, string $originalUrl, int $usedAmount, DateTime $createdAt = null, int $id = null)
    {
        $this->shortUrl = $shortUrl;
        $this->originalUrl = $originalUrl;
        $this->usedAmount = $usedAmount;
        if (!is_null($createdAt)) {
            $this->createdAt = $createdAt;
        }
        if (!is_null($id)) {
            $this->id = $id;
        }
    }

    /**
     * get the shortUrl
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->shortUrl;
    }

    /**
     * set the shortUrl
     * @param string $shortUrl
     * @return void
     */
    public function setShortUrl(string $shortUrl): void
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * get the originalUrl
     * @return string
     */
    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    /**
     * set the originalUrl
     * @param string $originalUrl
     * @return void
     */
    public function setOriginalUrl(string $originalUrl): void
    {
        $this->originalUrl = $originalUrl;
    }

    /**
     * get the usedAmount
     * @return int
     */
    public function getUsedAmount(): int
    {
        return $this->usedAmount;
    }

    /**
     * set the usedAmount
     * @param int $usedAmount
     * @return void
     */
    public function setUsedAmount(int $usedAmount): void
    {
        $this->usedAmount = $usedAmount;
    }

    /**
     * get the created_at
     * @return \DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * set the created_at
     * @param \DateTime $createdAt
     * @return void
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


    /**
     * get the id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * set the id
     * @param int $id 
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}
