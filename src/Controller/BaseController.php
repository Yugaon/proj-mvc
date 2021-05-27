<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\GameTwentyOne;
use App\DiceHand;
use App\Money;
use App\Entity\Books;
use App\Entity\ScoreList;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

class BaseController extends AbstractController
{
  /**
   * @Route("/")
  */
    public function index(): Response
    {
        return $this->render('dice.html.twig', [
            'message' => "Hello World in view",
        ]);
    }

    public function highscore(): Response
    {
        $product = new ScoreList();
        $repository = $this->getDoctrine()->getRepository(ScoreList::class);
        $products = $repository->findBy(
            [],
            ['poeng' => 'DESC'],
            10
        );
        $count = $repository->createQueryBuilder('u')
        ->select('count(u.procent)')
        ->getQuery()
        ->getSingleScalarResult();
        $sum = $repository->createQueryBuilder('u')
        ->select('sum(u.poeng)')
        ->getQuery()
        ->getSingleScalarResult();
        $sumrundor = $repository->createQueryBuilder('u')
        ->select('sum(u.Rundor)')
        ->getQuery()
        ->getSingleScalarResult();
        $sumvunnit = $repository->createQueryBuilder('u')
        ->select('sum(u.vunnit)')
        ->getQuery()
        ->getSingleScalarResult();
        $procent = ($sumvunnit/$sumrundor * 100);
        return $this->render('highscore.html.twig', [
            'scorelist' => $products,
            'totalrundor' => $count,
            'summa' => $sum,
            'procent' => round($procent),
        ]);
    }

    public function books(): Response
    {
        $books1 = $this->getDoctrine()
          ->getRepository(Books::class)
          ->findById(1);
        $books2 = $this->getDoctrine()
          ->getRepository(Books::class)
          ->findById(2);
        $books3 = $this->getDoctrine()
          ->getRepository(Books::class)
          ->findById(3);

          return $this->render('books.html.twig', [
              'book1' => $books1,
              'book2' => $books2,
              'book3' => $books3,
          ]);
    }

    public function diceGames(): Response
    {
        $request = Request::createFromGlobals();
        $session = new session();
        $session->set('total', 0);
        $session->set('yourmoney', 50);
        $session->set('computermoney', 150);
        $session->set('bet', 0);
        $session->set('invalid', " ");

        return $this->render('dice.html.twig', [
            'message' => "Hello World in view",
        ]);
    }

    public function diceTry(): Response
    {
        return $this->render('try.html.twig', [
            'message' => "Hello World in view",
        ]);
    }

    public function diceOneGame(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('runda', 0);
        $session->set('historik', []);
        $session->set('total', 0);
        return $this->render('21_1.html.twig', [
            'message' => null,
            'totale' => null,
            'realmessage' => null,
            'historik' => null,
            'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
            'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
            'yourbet' => null,
            'yourmoneynumber' => $session->get('yourmoney'),
            'computermoneynumber' => $session->get('computermoney'),
            'invalidbetting' => null,
        ]);
    }

    public function rollDice(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('idScore', 0);
        $object = new GameTwentyOne(6);
        $money = new Money();
        return $this->render('21_1.html.twig', [
        'message' => $object->roll($request),
        'totale' => $object->getTotal($request),
        'realmessage' => $object->Message(),
        'historik' => $object->getHistorik($request),
        'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
        'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
        'yourbet' => $money->betMessage($session->get('bet')),
        'yourmoneynumber' => $session->get('yourmoney'),
        'computermoneynumber' => $session->get('computermoney'),
        'invalidbetting' => null,
        ]);
    }

    public function reset(Request $request): Response
    {
        $object = new GameTwentyOne(6);
        $object->reset($request);
        $session = $request->getSession();
        return $this->render('21_1.html.twig', [
            'message' => null,
            'totale' => null,
            'realmessage' => null,
            'historik' => $object->getHistorik($request),
            'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
            'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
            'yourbet' => null,
            'yourmoneynumber' => $session->get('yourmoney'),
            'computermoneynumber' => $session->get('computermoney'),
            'invalidbetting' => null,
        ]);
    }

    public function betting(Request $request): Response
    {

        $object = new GameTwentyOne(6);
        $money = new Money();
        $object->reset($request);
        $session = $request->getSession();
        $session->set('invalid', " ");
        $bet = $request->get('bet');
        $session->set('bet', $bet);
        if ($session->get('bet') <= $session->get('computermoney')) {
            $money->moneyMinusComputer($request, $session->get('bet'));
            $money->moneyMinus($request, $session->get('bet'));
        }
        else {
            $session->set('bet', 0);
            $session->set('invalid',  "Invalid betting number, to high?");
        }


        return $this->render('21_1.html.twig', [
            'message' => null,
            'totale' => null,
            'realmessage' => null,
            'historik' => $object->getHistorik($request),
            'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
            'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
            'yourbet' => $money->betMessage($session->get('bet')),
            'yourmoneynumber' => $session->get('yourmoney'),
            'computermoneynumber' => $session->get('computermoney'),
            'invalidbetting' => $session->get('invalid'),


        ]);
    }

    public function stop(Request $request): Response
    {
        $session = $request->getSession();
        $object = new GameTwentyOne(6);
        $object->computer($request);
        return $this->render('21_1.html.twig', [
            'message' => null,
            'totale' => null,
            'realmessage' => $object->Message(),
            'historik' => $object->getHistorik($request),
            'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
            'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
            'yourbet' => null,
            'yourmoneynumber' => $session->get('yourmoney'),
            'computermoneynumber' => $session->get('computermoney'),
            'invalidbetting' => null,
        ]);
    }

    public function resetScore(Request $request): Response
    {
        $messages = "";
        $count = 0;
        $session = $request->getSession();
        $array = $session->get('historik');
        for ($i = 1; $i < sizeof($session->get('historik')) + 1; $i++) {
            if ($array[$i]['vinnare'] == "Du") {
                $count++;
            }
        }
        if ($session->get('runda') >= 5) {
            $entityManager = $this->getDoctrine()->getManager();

            $product = new ScoreList();

            $product->setRundor($session->get('runda'));
            $product->setVunnit($count);
            $rakna = $session->get('runda');
            $product->setProcent(($count / $rakna) * 100);
            $product->setPoeng($session->get('yourmoney'));
            $session->set('idScore', $product->getId());
            $repository = $this->getDoctrine()->getRepository(ScoreList::class);
            $entityManager->persist($product);
            $entityManager->flush();
        }

        $object = new GameTwentyOne(6);
        $object->ResetScore($request);

        return $this->render('21_1.html.twig', [
          'message' => null,
          'totale' => $object->getTotal($request),
          'realmessage' => null,
          'historik' => $object->getHistorik($request),
          'yourmoney' => "You have " . $session->get('yourmoney') . " to bet",
          'computermoney' => "The computer has " . $session->get('computermoney') . " to bet",
          'yourbet' => null,
          'yourmoneynumber' => $session->get('yourmoney'),
          'computermoneynumber' => $session->get('computermoney'),
          'invalidbetting' => null,
        ]);
    }

    public function diceTwoGame(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('runda', 0);

        $session->set('historik', []);
            return $this->render('21_2.html.twig', [
                'message' => null,
                'message2' => null,
                'totale' => null,
                'realmessage' => null,
                'historik' => [],
            ]);
    }

    public function rollTwoDice(Request $request): Response
    {
        $session = $request->getSession();
        $object = new DiceHand(2);
        $object->roll($request);
        $varde = $object->values();

        return $this->render('21_2.html.twig', [
            'message' => $varde[0],
            'message2' => $varde[1],
            'totale' => $object->sum($request),
            'realmessage' => $object->Message(),
            'historik' => $object->getHistorik($request)
        ]);
    }

    public function resetTwo(Request $request): Response
    {
        $session = $request->getSession();
        $object = new DiceHand(2);
        $object->reset($request);
        return $this->render('21_2.html.twig', [
            'message' => null,
            'message2' => null,
            'totale' => null,
            'realmessage' => null,
            'historik' => $object->getHistorik($request),
        ]);
    }

    public function stopTwo(Request $request): Response
    {
        $session = $request->getSession();
        $object = new DiceHand(2);
        $object->computer($request);
        return $this->render('21_2.html.twig', [
            'message' => null,
            'message2' => null,
            'totale' => null,
            'realmessage' => $object->Message(),
            'historik' => $object->getHistorik($request),
        ]);
    }

    public function resetScoreTwo(Request $request): Response
    {
        $session = $request->getSession();
        $object = new DiceHand(2);
        $object->ResetScore($request);
        return $this->render('21_2.html.twig', [
            'message' => null,
            'message2' => null,
            'totale' => $object->sum($request),
            'realmessage' => $object->Message(),
            'historik' => $object->getHistorik($request),
        ]);
    }
}
