<?php

namespace gift\appli\application_core\application\usecases;
use gift\appli\application_core\domain\entities\User;

interface AuthnInterface
{
    public function registerUser(string $email, string $password): void;
    public function byCredentials(string $email, string $password): User;
}