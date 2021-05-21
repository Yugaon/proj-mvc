<?php

declare(strict_types=1);

namespace App;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\DiceHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
* Test cases for class Guess.
*/
class FunctionsAndClass extends TestCase
{
    /**
    * Construct object and verify that the object has the expected
    * properties, use no arguments.
    */
    public function testForDice()
    {
        $dice = new Dice(6);
        $this->assertInstanceOf("\App\Dice", $dice);

        $res = $dice->roll();
        $this->assertEquals($res, $res);

        $getLast = $dice->getLastRoll();
        $this->assertEquals($res, $getLast);
    }

    public function testForDiceHand()
    {

        $dice = new DiceHand(6);
        $this->assertInstanceOf("\App\DiceHand", $dice);

        $res = $dice->values();
        $this->assertEquals($res, $res);

        $dice->Message();
    }

    public function testForGameTwentyOne()
    {
        $request = Request::createFromGlobals();
        $session = new Session(new MockArraySessionStorage());
        $request->setSession($session);
        $session->set('total', 21);
        $dice = new GameTwentyOne(6);
        $this->assertInstanceOf("\App\GameTwentyOne", $dice);

        $dice->Message();

        $this->assertEquals($dice->roll($request), $dice->getLastRoll());
        $session->set('total', 22);
        $this->assertEquals($dice->roll($request), $dice->getLastRoll());
        $this->assertEquals($session->get('total'), $dice->getTotal($request));
        $this->assertEquals($session->get('historik'), $dice->getHistorik($request));
        $this->assertEmpty($dice->resetScore($request));
        $dice->computer($request);
        $this->assertEquals($dice->computer($request), $dice->stop($request));
    }

    public function testForDiceHandSecond()
    {
        $request = Request::createFromGlobals();
        $session = new Session(new MockArraySessionStorage());
        $request->setSession($session);
        $session->set('total', 21);
        $dice = new Dicehand(2);

        $dice->Message();
        $dice->roll($request);
        $this->assertEmpty($dice->resetScore($request));
        $this->assertEquals($dice->sum($request), $session->get('total'));
        $this->assertEquals($session->get('historik'), $dice->getHistorik($request));
        $dice->computer($request);
        $this->assertEquals($dice->computer($request), $dice->stop($request));
    }
}
