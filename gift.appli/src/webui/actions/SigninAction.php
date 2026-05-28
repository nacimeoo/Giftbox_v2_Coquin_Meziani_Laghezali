<?php

declare(strict_types=1);

namespace gift\appli\webui\actions;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use gift\appli\application_core\domain\entities\Categorie;
use gift\appli\application_core\domain\entities\Prestation;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Illuminate\Database\QueryException;
use gift\appli\application_core\domain\Exception\CatalogueException;
use Slim\Views\Twig;
use gift\appli\application_core\application\usecases\AuthnService;
use gift\appli\application_core\application\providers\AuthnProviderInterface;
use gift\appli\application_core\application\providers\AuthnProvider;

class SigninAction extends AbstractAction
{

    private AuthnProviderInterface $authProvider;
    
    public function __construct($authnService) {
        $this->authProvider = new AuthnProvider();
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        if ($rq->getMethod() === 'GET') {
            $view = Twig::fromRequest($rq);
            return $view->render($rs, 'signin.twig');
        }


        $data = $rq->getParsedBody() ?? [];

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




    