<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Repository\PaiementRepository;
use App\Service\CartService;
use App\Service\PaiementService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PaiementController extends AbstractController
{
    #[Route('/paiement', name: 'paiement_index')]
    public function index(PaiementService $paiementService): Response
    {
        $sessionId = $paiementService->create();

        $paiementRequest = new Paiement();
        $paiementRequest->setCreatedAt(new DateTime());
        $paiementRequest->setStripeSessionId($sessionId);

        $entityMAnager = $this->getDoctrine()->getManager();
        $entityMAnager->persist($paiementRequest);
        $entityMAnager->flush(); 

        return $this->render('paiement/index.html.twig', [
            'sessionId'=> $sessionId
        ]);
    }

    #[Route('/paiement/success/{stripeSessionId}', name: 'paiement_success')]
    public function success(string $stripeSessionId , PaiementRepository $paiementRepository , CartService $cartService): Response
    {
        $paiementRequest = $paiementRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if (!$paiementRequest)
        {
            return $this->redirectToRoute('cart_index');
        }
    
        $paiementRequest->setValidated(true);
        $paiementRequest->setPaidAt(new DateTime());

        $entityMAnager = $this->getDoctrine()->getManager();
        $entityMAnager->flush();

        $cartService->clear();

        return $this->render('paiement/success.html.twig');
    }

    #[Route('/paiement/failure/{stripeSessionId}', name: 'paiement_failure')]
    public function failure(string $stripeSessionId , PaiementRepository $paiementRepository): Response
    {

        $paiementRequest = $paiementRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if (!$paiementRequest)
        {
            return $this->redirectToRoute('cart_index');
        }
    
        $entityMAnager = $this->getDoctrine()->getManager();
        $entityMAnager->remove($paiementRequest);
        $entityMAnager->flush();

        return $this->render('paiement/failure.html.twig');
    }









}




