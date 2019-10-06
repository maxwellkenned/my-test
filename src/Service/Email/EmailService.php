<?php

namespace App\Service\Email;

use App\Entity\Usuario;
use http\Exception\BadMessageException;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Response;
use Throwable;

class EmailService
{
    /** @var SendGrid */
    private $sendGrid;

    /**
     * EmailService constructor.
     */
    public function __construct()
    {
        $this->sendGrid = new SendGrid(getenv('SENDGRID_API_KEY'));
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
     * @throws SendGrid\Mail\TypeException
     */
    public function emailValidacaoLogin(Usuario $usuario): Response
    {
        $email = new Mail();
        $email->setFrom('validation@mytest.com', 'validation');
        $email->addTo($usuario->getEmail(), $usuario->getNome());
        $email->setSubject('Email de Validação');
        $email->addContent('text/html', $this->templateValidacao($usuario));

        return $this->enviarEmail($email);
    }

    /**
     * @param Usuario $usuario
     *
     * @return string
     */
    private function templateValidacao(Usuario $usuario): string
    {
        $link = 'http://localhost:8000/autenticacao/ativacao/' . $usuario->getHashAtivacao();

        $html = '<html><body>';
        $html .= '<span>Confirme seu email clicando no link de validação abaixo:</span>';
        $html .= '<br/>';
        $html .= "<a href='{$link}'> Clique aqui! </a>";
        $html .= '</body></html>';

        return $html;
    }
}