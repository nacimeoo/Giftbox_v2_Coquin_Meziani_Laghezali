<?php
declare(strict_types=1);
namespace gift\appli\webui\providers;

use gift\appli\application_core\application\usecases\AuthnService;
use Exception;
use gift\appli\application_core\domain\entities\User;

class AuthProvider implements AuthProviderInterface
{
    private AuthnService $authnService;

    public function __construct(AuthnService $authnService)
    {
        $this->authnService = new AuthnService();
    }

    public function signin(string $email, string $password): void
    {
        try {
            $userid = $this->authnService->byCredentials($email, $password);
            $user = User::find($userid);
            $_SESSION['user'] = ['id' => $user->id, 'email' => $user->email, 'role' => $user->role];
        } catch (Exception) {
            throw new Exception("mauvais email ou mot de passe");
        }
    }

    public function getSignedInUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
}