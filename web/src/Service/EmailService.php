<?php
namespace App\Service;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($to, $subject, $body): void
    {
        $email = (new Email())
            ->from('chiheb.menjli@esprit.tn')
            ->to($to)
            ->subject($subject)
            ->html($body);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
    }
}
