<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request ,EmailService $emailService): Response
    {
        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest(($request));

        if($formulaire->isSubmitted()){

            $data=$formulaire->getData();
            $email=$data['email'];
            $objet=$data['objet'];
            $message=$data['message'];
      
            $emailService->envoyer('admin@mon-super-site.com', "nouvelle demande" , "<h1> Tu as reçu un mail</h1>");
            return $this->renderForm('contact/success.html.twig', [
                'email_uti'=>$email,
                'objet_mail'=>$objet,
                'message'=>$message
            ]);


        } else {


       return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formAff'=>$formulaire
        ]);
    } }
}



       

        



    









 
