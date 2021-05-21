<?php

declare(strict_types=1);

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\DiceHand;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
* Test cases for class Guess.
*/
class Entitytest extends TestCase
{
    public function testForBooks()
    {

        $dice = new Books();
        $this->assertInstanceOf("\App\Entity\Books", $dice);


        $this->assertEmpty($dice->getId());
        $this->assertEmpty($dice->getTitel());
        $this->assertEquals($dice->setTitel("hey"), $dice);
        $this->assertEmpty($dice->getCode());
        $this->assertEquals($dice->setCode(1), $dice);
        $this->assertEmpty($dice->getAuthor());
        $this->assertEquals($dice->setAuthor("hey"), $dice);
        $this->assertEmpty($dice->getLinkPciture());
        $this->assertEquals($dice->setLinkPciture("hey"), $dice);
    }

    public function testForProducts()
    {

        $dice = new Product();
        $this->assertInstanceOf("\App\Entity\Product", $dice);


        $this->assertEmpty($dice->getId());
        $this->assertEmpty($dice->getName());
        $this->assertEquals($dice->setName("hey"), $dice);
        $this->assertEmpty($dice->getValue());
        $this->assertEquals($dice->setValue(1), $dice);
    }

    public function testForScoreList()
    {

        $dice = new ScoreList();
        $this->assertInstanceOf("\App\Entity\ScoreList", $dice);


        $this->assertEmpty($dice->getId());
        $this->assertEmpty($dice->getVunnit());
        $this->assertEquals($dice->setVunnit(1), $dice);
        $this->assertEmpty($dice->getRundor());
        $this->assertEquals($dice->setRundor(1), $dice);
        $this->assertEmpty($dice->getProcent());
        $this->assertEquals($dice->setProcent(1), $dice);
    }
}
