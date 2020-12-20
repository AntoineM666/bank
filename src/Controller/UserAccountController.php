<?php

namespace App\Controller;


use App\Entity\UserAccount;
use App\Form\UserAccount2Type;
use App\Repository\UserAccountRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/account")
 */
class UserAccountController extends AbstractController
{
    /**
     * @Route("/", name="user_account_index", methods={"GET"})
     */
    public function index(UserAccountRepository $userAccountRepository): Response
    {
        return $this->render('user_account/index.html.twig', [
            'user_accounts' => $userAccountRepository->findAll(),
     
            
        ]);
    }

    /**
     * @Route("/new", name="user_account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userAccount = new UserAccount();
        $form = $this->createForm(UserAccount2Type::class, $userAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userAccount);
            $entityManager->flush();

            return $this->redirectToRoute('user_account_index');
        }

        return $this->render('user_account/new.html.twig', [
            'user_account' => $userAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_account_show", methods={"GET"})
     */
    public function show(UserAccount $userAccount): Response
    {
        return $this->render('user_account/show.html.twig', [
            'user_account' => $userAccount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserAccount $userAccount): Response
    {
        $form = $this->createForm(UserAccount2Type::class, $userAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_account_index');
        }

        return $this->render('user_account/edit.html.twig', [
            'user_account' => $userAccount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserAccount $userAccount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAccount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userAccount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_account_index');
    }
}
