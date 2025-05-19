<?php

function validatePromotionData(array $data, array $files = [], bool $isUpdate = false): bool
{
    clearFieldErrors();

    // 1. Validation du nom
    if (empty(trim($data['nom'] ?? ''))) {
        setFieldError('nom', "Le nom de la promotion est obligatoire");
    } elseif (strlen(trim($data['nom'])) > 100) {
        setFieldError('nom', "Le nom ne doit pas dépasser 100 caractères");
    } elseif (promotionExistsByName(trim($data['nom']), $isUpdate ? ($data['id'] ?? null) : null)) {
        setFieldError('nom', "Une promotion avec ce nom existe déjà");
    }

    // 2. Validation des dates
    $dateFormat = 'Y-m-d';

    // Date de début
    if (empty($data['date_debut'] ?? '')) {
        setFieldError('date_debut', "La date de début est obligatoire");
    } elseif (!validateDate($data['date_debut'], $dateFormat)) {
        setFieldError('date_debut', "Format de date invalide (AAAA-MM-JJ attendu)");
    }

    // Date de fin
    if (empty($data['date_fin'] ?? '')) {
        setFieldError('date_fin', "La date de fin est obligatoire");
    } elseif (!validateDate($data['date_fin'], $dateFormat)) {
        setFieldError('date_fin', "Format de date invalide (AAAA-MM-JJ attendu)");
    }

    // Cohérence entre les dates
    if (
        !empty($data['date_debut']) && !empty($data['date_fin']) &&
        strtotime($data['date_fin']) <= strtotime($data['date_debut'])
    ) {
        setFieldError('date_fin', "La date de fin doit être postérieure à la date de début");
    }

    // 3. Validation du nombre d'apprenants
    if (!isset($data['nombre_apprenants']) || $data['nombre_apprenants'] === '') {
        setFieldError('nombre_apprenants', "Le nombre d'apprenants est obligatoire");
    } elseif (!is_numeric($data['nombre_apprenants']) || $data['nombre_apprenants'] <= 0) {
        setFieldError('nombre_apprenants', "Doit être un nombre positif");
    }

    // 5. Validation des référentiels
    if (empty($data['referentiels'] ?? []) || !is_array($data['referentiels'])) {
        setFieldError('referentiels', "Au moins un référentiel doit être sélectionné");
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
