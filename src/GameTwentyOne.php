<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ScoreList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameTwentyOne
{
    public $lastroll;
    public $lastrollcomputer;
    private $sides;
    private $message;

    public function __construct(int $sides)
    {
        $this->sides = $sides;
    }

    public function roll(Request $request)
    {
        $session = $request->getSession();

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

        $this->lastroll = random_int(1, $this->sides);
        $total = $session->get('total');
        $session->set('total', $total + $this->lastroll);

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
        return $this->lastroll;
    }

    public function getLastRoll()
    {
        return $this->lastroll;
    }

    public function getTotal($request)
    {
        $session = $request->getSession();
        return $session->get('total');
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

    public function message()
    {
        return $this->message;
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

    public function getHistorik($request)
    {
        $session = $request->getSession();
        return $session->get('historik');
    }

    public function stop($request)
    {
        return $this->computer($request);
    }
}
