<?php

namespace gift\appli\application_core\application\usecases;

use gift\appli\application_core\domain\entities\User;

class AuthnService implements AuthnInterface
{

    public function registerUser(string $email, string $password): void
    {
        try{

        if (User::where('user_id', $email)->exists()) {
            throw new \Exception("Un utilisateur avec cet email existe déjà.");
        }

            $user = new User();

            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$email) {
                throw new \InvalidArgumentException("Email invalide.");
            }

            $mdp = password_hash($password, PASSWORD_BCRYPT);

            $user->user_id = $email;
            $user->password = $mdp;
            $user->role = User::ROLE_USER;

            $user->save();   

        }catch(\Exception $e){
            throw new \Exception("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
        }
    }

    public function byCredentials(string $email, string $password): String
    {
        try {
            $user = User::where('user_id', $email)->firstOrFail();

            if (!$user) {
                throw new \Exception("login ou mot de passe incorrect.");
            }

            if (!password_verify($password, $user->password)) {
                throw new \Exception("login ou mot de passe incorrect.");
            }

            return $user->id;

        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la vérification des credentials : " . $e->getMessage());
        }
    }

}
