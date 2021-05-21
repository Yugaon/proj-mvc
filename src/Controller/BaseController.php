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
        $repository = $this->getDoctrine()->getRepository(ScoreList::class);
        $products = $repository->findBy(
            [],
            ['procent' => 'DESC'],
            10
        );
        return $this->render('highscore.html.twig', [
            'scorelist' => $products,
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
        ]);
    }

    public function rollDice(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('idScore', 0);
        $object = new GameTwentyOne(6);
        return $this->render('21_1.html.twig', [
        'message' => $object->roll($request),
        'totale' => $object->getTotal($request),
        'realmessage' => $object->Message(),
        'historik' => $object->getHistorik($request),
        ]);
    }

    public function reset(Request $request): Response
    {
        $object = new GameTwentyOne(6);
        $object->reset($request);
        return $this->render('21_1.html.twig', [
            'message' => null,
            'totale' => null,
            'realmessage' => null,
            'historik' => $object->getHistorik($request),
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
