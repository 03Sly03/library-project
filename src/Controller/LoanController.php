<?php

namespace App\Controller;

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
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
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
     * @Route("/{id}", name="loan_show", methods={"GET"})
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

}
