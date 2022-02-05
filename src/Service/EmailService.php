<?php


namespace App\Service;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService{
    private $envoyeur;
      public function __construct(MailerInterface $mailer){
           $this->envoyeur=$mailer;

      }
        public function envoyer(string $destinataire, string $objet , string $contenu):void{
            $email=(new Email())
            ->from('no-reply@mon-super-site.com')
            ->to($destinataire)
            ->subject($objet)
            ->html($contenu);
            $this->envoyeur->send($email);

        }
}