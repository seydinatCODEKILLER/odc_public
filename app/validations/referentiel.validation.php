<?php

function validateReferentielsData(array $data, array $files = [], bool $isUpdate = false): bool
{
    clearFieldErrors();

    // 1. Validation du nom
    if (empty(trim($data['nom'] ?? ''))) {
        setFieldError('nom', "Le nom de la referentiel est obligatoire");
    } elseif (strlen(trim($data['nom'])) > 200) {
        setFieldError('nom', "Le nom ne doit pas dépasser 100 caractères");
    } elseif (referentielExistsByName(trim($data['nom']), $isUpdate ? ($data['id'] ?? null) : null)) {
        setFieldError('nom', "Une referentiel avec ce nom existe déjà");
    }

    //Description
    if (empty(trim($data['description'] ?? ''))) {
        setFieldError('description', "La description est obligatoire");
    }

    //Description
    if (empty(trim($data['session'] ?? ''))) {
        setFieldError('session', "La session est obligatoire");
    }


    // 3. Validation du nombre d'apprenants
    if (!isset($data['capacite']) || $data['capacite'] === '') {
        setFieldError('capacite', "La capacite est obligatoire");
    } elseif (!is_numeric($data['capacite']) || $data['capacite'] <= 0) {
        setFieldError('capacite', "Doit être un nombre positif");
    }

    // 6. Validation de l'image (uniquement pour l'ajout ou si nouvelle image fournie)
    if (!$isUpdate && empty($files['image']['name'] ?? '')) {
        setFieldError('image', "L'image est obligatoire");
    }

    // Si image fournie (ajout ou modification)
    if (!empty($files['image']['name'])) {
        $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Vérification du type
        if (!array_key_exists($files['image']['type'], $allowedTypes)) {
            setFieldError('image', "Type de fichier non autorisé (JPEG, PNG ou GIF uniquement)");
        }

        // Vérification de la taille
        elseif ($files['image']['size'] > $maxSize) {
            setFieldError('image', "L'image ne doit pas dépasser 2 Mo");
        }

        // Vérification des erreurs d'upload
        elseif ($files['image']['error'] !== UPLOAD_ERR_OK) {
            setFieldError('image', "Erreur lors du téléchargement du fichier");
        }
    }

    return empty(getFieldErrors());
}
