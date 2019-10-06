<?php

namespace App\Service\Email;

use App\Entity\Usuario;
use App\Exception\TemplateNotFoundException;
use http\Exception\BadMessageException;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Throwable;

class EmailService
{
    /** @var SendGrid */
    private $sendGrid;

    private $templating;

    /**
     * EmailService constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->sendGrid = new SendGrid(getenv('SENDGRID_API_KEY'));
        $this->templating = $container->get('twig');
    }

    /**
     * @param Mail $email
     *
     * @return Response|null
     */
    public function enviarEmail(Mail $email): ?Response
    {
        try {
            return $this->sendGrid->send($email);
        } catch (Throwable $e) {
            throw new BadMessageException($e->getMessage());
        }
    }

    /**
     * @param Usuario $usuario
     *
     * @return Response
     */
    public function emailValidacaoLogin(Usuario $usuario): Response
    {
        try {
            $email = new Mail();
            $email->setFrom('validation@mytest.com', 'Email de validação');
            $email->addTo($usuario->getEmail(), $usuario->getNome());
            $email->setSubject('Email de Validação');
            $email->addContent('text/html', $this->templateValidacao($usuario));

            return $this->enviarEmail($email);
        } catch (Throwable $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    /**
     * @param Usuario $usuario
     *
     * @return string
     */
    private function templateValidacao(Usuario $usuario): string
    {
        try {
            return $this->templating->render('email/validacao.html.twig', ['hash' => $usuario->getHashAtivacao()]);
        } catch (Throwable $e) {
            throw new TemplateNotFoundException($e->getMessage());
        }
    }
}