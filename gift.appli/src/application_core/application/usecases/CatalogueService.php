<?php
declare(strict_types=1);

namespace gift\appli\src\application_core\application\usecases;

use gift\core\domain\entities\Categorie;
use gift\core\domain\entities\Prestation;
use gift\core\domain\entities\CoffretType;
use gift\core\domain\entities\Theme;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use ApplicationCore\Domain\Exceptions\CatalogueException;

class CatalogueService implements CatalogueInterface 
{
    public function getCategories(): array 
    {
        try {
            return Categorie::all()->toArray();
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur lors de la récupération des catégories.");
        }
    }

    public function getCategorieById(int $id): array 
    {
        try {
            return Categorie::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueException("La catégorie avec l'ID $id est introuvable.", 404);
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur de base de données.");
        }
    }

    public function getPrestationById(string $id): array 
    {
        try {
            return Prestation::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueException("La prestation avec l'ID $id est introuvable.", 404);
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur de base de données.");
        }
    }

    public function getPrestationsbyCategorie(int $categ_id): array 
    {
        try {
            Categorie::findOrFail($categ_id);
            return Prestation::where('cat_id', '=', $categ_id)->get()->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueException("Catégorie introuvable, impossible de charger ses prestations.", 404);
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur de base de données.");
        }
    }

    public function getThemesCoffrets(): array 
    {
        try {
            $coffrets = CoffretType::all('id', 'libelle', 'description', 'theme_id')->toArray();
            $themes = Theme::all('id', 'libelle')->toArray();
            
            return [
                'themes' => $themes,
                'coffrets' => $coffrets
            ];
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur lors de la récupération des thèmes et coffrets.");
        }
    }

    public function getCoffretById(int $id): array 
    {
        try {
            return CoffretType::with('prestations')->findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CatalogueException("Le coffret avec l'ID $id est introuvable.", 404);
        } catch (QueryException $e) {
            throw new CatalogueException("Erreur de base de données.");
        }
    }
}