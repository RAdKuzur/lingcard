<?php

namespace App\Services;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
class MailService
{
    private $dsn;
    private $from;

    public function __construct()
    {
        $this->dsn = env("MAIL_DSN");
        $this->from = env("MAIL_FROM_ADDRESS");
    }

    public function send($to, $subject, $text = null, $html = null)
    {
        $transport = Transport::fromDsn($this->dsn)
            ->setUsername(env('MAIL_USERNAME'))
            ->setPassword(env('MAIL_PASSWORD'));
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from($this->from)
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($html);

        $mailer->send($email);
    }
}
