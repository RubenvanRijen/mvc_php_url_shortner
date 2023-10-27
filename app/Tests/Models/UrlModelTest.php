<?php

namespace MvcPhpUrlShortner\Tests\Models;

use DateTime;
use Mockery;
use Mockery\MockInterface;
use MvcPhpUrlShortner\Database\Database;
use MvcPhpUrlShortner\Database\DatabaseMock;
use MvcPhpUrlShortner\Database\Migrations\AppMigration;
use MvcPhpUrlShortner\Database\Seeders\AppSeeder;
use MvcPhpUrlShortner\Models\UrlModel;
use MvcPhpUrlShortner\Objects\UrlObject;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class UrlModelTest extends TestCase
{

    /** @var UrlModel */
    private $urlModel;

    /** @var MockInterface */
    private $pdoMock;

    /** @var PDO */
    private PDO $db;


    protected function setUp(): void
    {
        parent::setUp();

        // create the database Connection.
        $this->db = Database::getInstance(true);

        //seed the database
        $migration = new AppMigration();
        $migration->unMigrateApplication();
        $migration->migrateApplication();
        $seeder = new AppSeeder();
        $seeder->seedApplication();

        // Create a mock for the PDO class
        $this->pdoMock = Mockery::mock(PDO::class);

        // Create an instance of the UrlModel and inject the mock PDO object
        $this->urlModel = new UrlModel();

        //seed the database
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testCreateShortUrl()
    {
        // create a short url and insert it into the database.
        $urlObjectcreate =  $this->urlModel->createShortUrl("https://www.php.net/manual/en/class.pdostatement.php");

        $urlObjectGet = $this->urlModel->getUrlDataById($urlObjectcreate->getId());

        $this->assertSame($urlObjectcreate->getId(), $urlObjectGet->getId());
        $this->assertSame($urlObjectcreate->getOriginalUrl(), "https://www.php.net/manual/en/class.pdostatement.php");
        $this->assertSame($urlObjectcreate->getShortUrl(), $urlObjectGet->getShortUrl());
        $this->assertSame($urlObjectcreate->getOriginalUrl(), $urlObjectGet->getOriginalUrl());
    }

    public function testGetUrls()
    {
        $urlObjects =  $this->urlModel->getUrls(1, 20);
        $id = $urlObjects[0]["id"];
        // Define a sample short URL and an expected URL object
        $this->assertSame($id, 1);
        $this->assertSame(count($urlObjects), 5);
    }

    public function testGetUrlsSortedByDate()
    {
        $urlObjects =  $this->urlModel->getUrlsSortedByDate(1, 20);
        $id = $urlObjects[0]["id"];
        // Define a sample short URL and an expected URL object
        $this->assertSame($id, 5);

        // create new date with 2 years in the future, like in the seed data.
        $dateTimeObj = new DateTime();
        $datTimefuture = date_format($dateTimeObj->modify('+2 years'), 'Y/m/d');

        // convert the database date into a format.
        $date = strtotime($urlObjects[0]['created_at']);
        $newformat = date('Y/m/d', $date);

        $this->assertSame($datTimefuture, $newformat);
        $this->assertSame(count($urlObjects), 5);
    }
    public function testGetTotalUrlsCount()
    {
        $urlCount =  $this->urlModel->getTotalUrlsCount();
        $this->assertSame(5, $urlCount);
    }

    public function testShortUrlExists()
    {
        $urlObjects =  $this->urlModel->getUrls(1, 20);
        $urlExcist =  $this->urlModel->shortUrlExists($urlObjects[0]['short_url']);
        $urlDoesntExcist =  $this->urlModel->shortUrlExists("qwertyuiop");

        $this->assertSame(true, $urlExcist);
        $this->assertSame(false, $urlDoesntExcist);
    }

    public function testOriginalUrlExists()
    {
        $urlObjects =  $this->urlModel->getUrls(1, 20);
        $urlExcist =  $this->urlModel->originalUrlExists($urlObjects[0]['original_url']);
        $urlDoesntExcist =  $this->urlModel->shortUrlExists("qwertyuiop");

        $this->assertSame(true, $urlExcist);
        $this->assertSame(false, $urlDoesntExcist);
    }

    public function testIncreaseUsedAmount()
    {
        $this->urlModel->increaseUsedAmount(1);
        $urlObjectCorrect =  $this->urlModel->getUrlDataById(1);

        $this->urlModel->increaseUsedAmount(2);
        $urlObjectWrong =  $this->urlModel->getUrlDataById(2);

        $this->assertSame(1, $urlObjectCorrect->getUsedAmount());
        $this->assertNotSame(2, $urlObjectWrong->getUsedAmount());
    }

    public function testGetUrlDataByShortUrl()
    {
        $urlObject = $this->urlModel->getUrlDataByShortUrl("DUJFKEDH6");
        $this->assertSame("https://music.youtube.com/", $urlObject->getOriginalUrl());
        $this->assertNotSame(null, $urlObject);
    }

    public function testGetUrlDataByOriginalUrl()
    {
        $urlObject = $this->urlModel->getUrlDataByOriginalUrl("https://music.youtube.com/");
        $this->assertSame("DUJFKEDH6", $urlObject->getShortUrl());
        $this->assertNotSame(null, $urlObject);
    }

    public function testGetUrlDataById()
    {
        $urlObject = $this->urlModel->getUrlDataById(1);
        $this->assertSame("DUJFKEDH6", $urlObject->getShortUrl());
        $this->assertNotSame(null, $urlObject);
    }
}
