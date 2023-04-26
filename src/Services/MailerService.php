<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService 
{
    public function __construct( MailerInterface $mailerService, Environment $twig) {
        $this->mailer = $mailerService;
        $this->twig = $twig;
    }
    
    public function send(string $subject, string $from, string $to, string $template, array $parameters) : void {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html(
                $this->twig->render($template, $parameters),
                'text/html'
            ); 

            $this->mailer->send($email);
    }
}

