<?php


namespace App\Service;


use App\Entity\Article;
use Twig\Environment;

class Mailer
{
    private $sender;
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, string $sender, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->twig = $twig;
    }

    public function sendMail(Article $article, $recipient)
    {
        $message = (new \Swift_Message('Un nouvel article vient d\'être publié !'))
            ->setFrom($this->sender)
            ->setTo($recipient)
            ->setSubject('DremBlog Article - ' . $article->getTitle())
            ->setBody($this->twig->render(
                'article/mailer/mail.html.twig',
                [
                    'article' => $article
                ]
            ),
            'text/html');
        $this->mailer->send($message);
    }
}
