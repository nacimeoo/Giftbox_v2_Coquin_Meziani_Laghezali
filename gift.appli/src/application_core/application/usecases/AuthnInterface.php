<?php

namespace gift\appli\application_core\application\usecases;

interface AuthnInterface
{
    public function registerUser(string $email, string $password): void;
    public function byCredentials(string $email, string $password): String;
}