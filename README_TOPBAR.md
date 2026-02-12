# Documentation du Topbar Dynamique

Ce projet intègre désormais un composant **Topbar** unifié et dynamique pour la gestion des actions principales (Recherche et Ajout) sur les pages de listes (Index).

## 1. Vue d'ensemble

Le composant se trouve dans `resources/views/layouts/topbar-actions.blade.php`. Il fournit :
- Une barre de recherche standardisée.
- Un bouton d'action "Ajouter" contextuel.
- Une gestion automatique des paramètres de requête (filtres existants préservés).

## 2. Intégration

Pour ajouter le Topbar à une nouvelle page, incluez simplement le composant au début de votre section de contenu, en passant les paramètres nécessaires.

### Exemple de code :

```blade
@include('layouts.topbar-actions', [
    'searchPlaceholder' => 'Rechercher...',       // Texte indicatif dans la barre de recherche
    'addRoute'          => 'route.name.create',   // Nom de la route pour le bouton d'ajout
    'addButtonLabel'    => 'Ajouter Nouveau',     // (Optionnel) Texte du bouton
    'addRouteParams'    => ['id' => 1]            // (Optionnel) Paramètres pour la route
])
```

## 3. Configuration Backend

Le champ de recherche utilise le paramètre `search` (ou `q`). Assurez-vous que votre contrôleur gère ce paramètre.

### Exemple dans le contrôleur :

```php
public function index(Request $request)
{
    $query = Model::query();

    if ($request->has('search')) {
        $term = $request->search;
        $query->where('name', 'like', "%{$term}%");
    }
    
    // ...
}
```

## 4. Pages mises à jour

Les pages suivantes utilisent déjà ce système :
- **Membres** (`members.index`) : Recherche de membres, Ajout de membre.
- **Types d'Entraînement** (`training-types.index`) : Recherche de types, Ajout de type.
- **Plans** (via `training-types.show`) : Recherche de plans, Ajout de plan.

## 5. Tests

Un test d'intégration est disponible dans `tests/Feature/TopbarIntegrationTest.php` pour vérifier la présence et le bon fonctionnement du Topbar.
