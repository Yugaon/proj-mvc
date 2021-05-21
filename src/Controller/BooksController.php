<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;

class BooksController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function index(): Response
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }


    /**
    * @Route("/books/create", name="create_books")
    */
    public function createProduct(): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action:
        //  createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Books();
        $product->setTitel("Alice in wonderland");
        $product->setCode(0 - 4189 - 3721 - 4);
        $product->setAuthor("Lewis Carroll");
        $product->setLinkPciture("alice_wonderland.jpg");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

        /**
     * @Route("/books/all", name="find_all_books")
     */
    public function findAllProduct(
        EntityManagerInterface $entityManager
    ): Response {
        $products = $entityManager
            ->getRepository(Books::class)
            ->findAll();

        return $this->json($products);
    }
}
