<?php

namespace gift\appli\application_core\application\usecases;

interface BoxInterface
{
    public function getBoxByToken(string $token): array;
    public function generateToken(string $boxId, string $userId): string;
}