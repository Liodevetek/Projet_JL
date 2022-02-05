<?php

namespace App\Service;

use \Stripe\StripeClient;

class PaiementService 
{
    private $cartservice;
    private $stripe;

    public function __construct(CartService $cartservice)
  {
   $this->cartservice= $cartservice;
   $this->stripe = new StripeClient('sk_test_51KMuNgBaKZhG9Y5ALRB0z95FfzC6xcinPOrjAHftKBaddDa9TBC1dDskrlX5PdLlJaMTSrffzQKYHArEXx6lWDcl00qtkjjILx');
  }

    public function create(): string
    {
        $cart = $this->cartservice->get();
        $items = [];
      foreach ($cart['elements'] as $produitId => $element)
       {
            $items[]= [
             'amount' => $element['produit']->getPrix() * 100,
             'quantity' => $element['quantity'],
             'currency'=> 'eur',
             'name'=> $element['produit']->getNom()



            ];
   
        }
       $protcol = $_SERVER['HTTPS'] ? 'https' : 'http';
       $host =$_SERVER['SERVER_NAME'];
       $successUrl = $protcol . '://'  . $host .'/paiement/success/(CHECKOUT_SESSION_ID)';
       $failureUrl = $protcol . '://'  . $host .'/paiement/failure/(CHECKOUT_SESSION_ID)';
     
       $session = $this->stripe->checkout->sessions->create([
        'success_url'=>$successUrl,
        'cancel_url' => $failureUrl,
        'payment_method_types'=>['card'],
        'mode'=> 'payment',
        'line_items'=> $items
        
       ]);

       return $session->id ;
    }

}