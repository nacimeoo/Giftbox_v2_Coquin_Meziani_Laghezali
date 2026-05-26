<?php
namespace gift\appli\application_core\application\usecases;

interface BoxMangementInterface
{
    public function createBox(array $data, string $userId): string;
    public function addPrestationToBox(string $boxId, string $prestaId, int $quantite, string $userId): void;
    public function getBoxWithPrestations(string $boxId, string $userId): array;
    public function validerBox(string $boxId, string $userId): void;
}