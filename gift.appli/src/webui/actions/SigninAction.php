<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Views\Twig;
use gift\appli\webui\providers\AuthProvider;
use gift\appli\webui\providers\CsrfTokenProvider;
use Slim\Exception\HttpForbiddenException;

class SigninAction extends AbstractAction
{

    private AuthProvider $authProvider;
    
    public function __construct(AuthProvider $authProvider) {
        $this->authProvider = $authProvider;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        if ($rq->getMethod() === 'GET') {
            $view = Twig::fromRequest($rq);
            return $view->render($rs, 'signin.twig');
        }

        $data = $rq->getParsedBody() ?? [];
        $csrfToken = $data['csrf_token'] ?? '';
        try {
            (new CsrfTokenProvider())->check($csrfToken);
        } catch (\Exception $e) {
            throw new HttpForbiddenException($rq, "Erreur de sécurité CSRF : " . $e->getMessage());
        }

        $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $data['password'] ?? '';
        if (!$email || !$password) {
            throw new HttpBadRequestException($rq, "Email ou mot de passe manquant.");
        }

        try {
            $this->authProvider->signIn($email, $password);

            return $rs->withHeader('Location', '/')->withStatus(302);

        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($rq, "Erreur lors de l'authentification : " . $e->getMessage());
        }

    }
}




    