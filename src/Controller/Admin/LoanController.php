<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\BorrowerRepository;
use App\Repository\LoanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="admin_loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository, BorrowerRepository $borrowerRepository): Response
    {

        $loans = $loanRepository->findAll();

        if ($this->isGranted('ROLE_BORROWER')) {
            $user = $this->getUser();
            $borrower = $borrowerRepository->findOneByUser($user);
            $loans = $borrower->getLoans();
        }
        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
        ]);
    }

    /**
     * @Route("/new", name="admin_loan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('admin_loan_index');
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_loan_show", methods={"GET"})
     */
    public function show(Loan $loan, BorrowerRepository $borrowerRepository): Response
    {

        if ($this->isGranted('ROLE_BORROWER')) {
            $user = $this->getUser();
            $borrower = $borrowerRepository->findOneByUser($user);
            
            if(!$borrower->getLoans()->contains($loan)) {
                throw new NotFoundHttpException();
            }
        }

        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_loan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Loan $loan, LoanRepository $loanRepository): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_loan_index');
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_loan_delete", methods={"POST"})
     */
    public function delete(Request $request, Loan $loan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_loan_index');
    }
}
