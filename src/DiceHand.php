<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class DiceHand
{
    private $dices;
    private $values;
    private $sides = 6;
    private $message;
    public $lastrollcomputer;


    public function __construct(int $dices)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice($this->sides);
            $this->values[] = null;
        }
    }

    public function roll(Request $request)
    {

        for ($i = 0; $i < count($this ->dices); $i++) {
            $save = random_int(1, $this->sides);
            $this->values[$i] = $save;
        }

        $session = $request->getSession();
        $total = $session->get('total');
        $session->set('total', $total + array_sum($this->values));
        if ($session->get('total') == 21) {
            $this->message = 'Congratulations you won!';
            $historia = "Du";
            $nyrunda = $session->get('runda');
            $session->set('runda', $nyrunda + 1);
            $runda = $session->get('runda');
            $historik = array(
              'vinnare' => $historia,
              'runda' => $runda
            );
            $innanhistorik = $session->get('historik');
            $innanhistorik[$runda] = $historik;
            $session->set('historik', $innanhistorik);

            $this->reset($request);
        } elseif ($session->get('total') > 21) {
            $this->message = 'You lost play again!';
            $historia = "Computer";
            $nyrunda = $session->get('runda');
            $session->set('runda', $nyrunda + 1);
            $runda = $session->get('runda');
            $historik = array(
              'vinnare' => $historia,
              'runda' => $runda
            );
            $innanhistorik = $session->get('historik');
            $innanhistorik[$runda] = $historik;
            $session->set('historik', $innanhistorik);

            $this->reset($request);
        }
    }

    public function message()
    {
        return $this->message;
    }

    public function reset(Request $request)
    {
        $session = $request->getSession();
        $session->set('total', 0);
    }

    public function resetScore($request)
    {
        $session = $request->getSession();
        $session->set('historik', []);
        $session->set('runda', 0);
    }

    public function values()
    {
        return $this->values;
    }

    public function sum($request)
    {
        $session = $request->getSession();

        return $session->get('total');
    }

    public function stop($request)
    {
        return $this->computer($request);
    }

    public function getHistorik($request)
    {
        $session = $request->getSession();
        return $session->get('historik');
    }

    public function computer($request)
    {
        $session = $request->getSession();
        $computerValue = 0;
        while ($computerValue < 21 or $computerValue == $session->get('total')) {
            $this->lastrollcomputer = random_int(1, $this->sides);
            $computerValue = $computerValue + $this->lastrollcomputer;
            if ($computerValue == 21 or $computerValue == $session->get('total')) {
                $session->set('total', 0);
                $this->message = 'You lost play again!';
                $historia = "Computer";
                $nyrunda = $session->get('runda');
                $session->set('runda', $nyrunda + 1);
                $runda = $session->get('runda');
                $historik = array(
                  'vinnare' => $historia,
                  'runda' => $runda
                );
                $innanhistorik = $session->get('historik');
                $innanhistorik[$runda] = $historik;
                $session->set('historik', $innanhistorik);
                break;
            } else if ($computerValue > 22 and $computerValue != 21) {
                  $session->set('total', 0);
                  $this->message = 'Congratulations you won!';
                  $historia = "Du";
                  $nyrunda = $session->get('runda');
                  $session->set('runda', $nyrunda + 1);
                  $runda = $session->get('runda');
                  $historik = array(
                    'vinnare' => $historia,
                    'runda' => $runda
                  );
                  $innanhistorik = $session->get('historik');
                  $innanhistorik[$runda] = $historik;
                  $session->set('historik', $innanhistorik);
                  break;
            }
        }
    }
}
