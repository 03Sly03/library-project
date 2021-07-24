<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Entity\User;
use App\Form\BorrowerType;
use App\Repository\BorrowerRepository;
use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/borrower")
 */
class BorrowerController extends AbstractController
{
    /**
     * @Route("/", name="borrower_index", methods={"GET"})
     */
    public function index(BorrowerRepository $borrowerRepository, LoanRepository $loanRepository): Response
    {
        $borrowers = $borrowerRepository->findAll();

        if ($this->isGranted('ROLE_BORROWER')) {
            $user = $this->getUser();
            $borrower = $borrowerRepository->findOneByUser($user);
            $loans = $borrower->getLoans();
            foreach($loans as $oneLoan){
                    $loan = $oneLoan;
            }
            $borrower = $loan->getBorrower();

        }
        return $this->render('borrower/index.html.twig', [
            'borrowers' => $borrowers,
        ]);
    }

    /**
     * @Route("/new", name="borrower_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $borrower = new Borrower();
        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $borrower->getUser();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('user')->get('plainPassword')->getData()
                )
            );


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($borrower);
            $entityManager->flush();

            return $this->redirectToRoute('borrower_index');
        }

        return $this->render('borrower/new.html.twig', [
            'borrower' => $borrower,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="borrower_show", methods={"GET"})
     */
    public function show(Borrower $borrower, BorrowerRepository $borrowerRepository): Response
    {

        $response = $this->redirectBorrower('borrower_show', $borrower, $borrowerRepository);

        if ($response) {
            return $response;
        }

        return $this->render('borrower/show.html.twig', [
            'borrower' => $borrower,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="borrower_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Borrower $borrower, BorrowerRepository $borrowerRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $response = $this->redirectBorrower('borrower_edit', $borrower, $borrowerRepository);

        if ($response) {
            return $response;
        }

        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $borrower->getUser();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('user')->get('plainPassword')->getData()
                )
            );

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('borrower_index');
        }

        return $this->render('borrower/edit.html.twig', [
            'borrower' => $borrower,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="borrower_delete", methods={"POST"})
     */
    public function delete(Request $request, Borrower $borrower): Response
    {

        if ($this->isGranted('ROLE_BORROWER')) {
            throw new AccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete'.$borrower->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($borrower);
            $entityManager->flush();
        }

        return $this->redirectToRoute('borrower_index');
    }

    private function redirectBorrower(string $route, Borrower $borrower, BorrowerRepository $borrowerRepository)
    {
        if ($this->isGranted('ROLE_BORROWER')) {
            $user = $this->getUser();
            $userBorrower = $borrowerRepository->findOneByUser($user);
            if ($borrower->getId() != $userBorrower->getId()) {
                return $this->redirectToRoute($route, [
                    'id' => $userBorrower->getId(),
                ]);
            }
        }

        return null;
    }
}
