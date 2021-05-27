<?php

declare(strict_types=1);

namespace App;

class Money
{
    public $betmessage;
    private $sides;

    public function moneyPlus($request, $moneyToAdd)
    {
        $session = $request->getSession();
        $currentMoney = $session->get('yourmoney');
        $currentMoney = $currentMoney + $moneyToAdd;

        return $moneyToAdd;
    }

    public function moneyMinus($request, $moneyToLose)
    {
        $session = $request->getSession();
        $currentMoney = $session->get('yourmoney');
        $currentMoney = $currentMoney - $moneyToLose;
        $session->set('yourmoney', $currentMoney);
        return $currentMoney;
    }

    public function moneyMinusComputer($request, $moneyToLose)
    {
        $session = $request->getSession();
        $currentMoney = $session->get('computermoney');
        $currentMoney = $currentMoney - $moneyToLose;
        $session->set('computermoney', $currentMoney);
        return $currentMoney;
    }

    public function betMessage($message)
    {
        $this->betMessage = "You are now betting " . $message;

        return $this->betMessage;
    }
}
