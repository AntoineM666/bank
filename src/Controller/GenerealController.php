<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AddaccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenerealController extends AbstractController
{
    /**
     * @Route("/", name="general")
     */
    public function index(): Response
    {
        return $this->render('general/index.html.twig', [
            'controller_name' => 'GenerealController',
        ]);
    }


     /**
     * @Route("/addaccount", name="addaccount", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $Account = new Account();
        $form = $this->createForm(AddaccountType::class, $Account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Account);
            $entityManager->flush();

            return $this->redirectToRoute('general');
        }

        return $this->render('general/addaccount.html.twig', [
            'account' => $Account,
            'form' => $form->createView(),
        ]);
    }

}
