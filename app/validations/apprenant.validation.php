<?php

function validateApprenantData(array $data, array $files = [], bool $isUpdate = false): bool
{
    clearFieldErrors();

    // 1. Validation du nom
    if (empty(trim($data['nom'] ?? ''))) {
        setFieldError('nom', "Le nom de l'apprenant est obligatoire");
    } elseif (strlen(trim($data['nom'])) > 50) {
        setFieldError('nom', "Le nom ne doit pas dépasser 50 caractères");
    }

    // 2. Validation du prénom
    if (empty(trim($data['prenom'] ?? ''))) {
        setFieldError('prenom', "Le prénom de l'apprenant est obligatoire");
    } elseif (strlen(trim($data['prenom'])) > 50) {
        setFieldError('prenom', "Le prénom ne doit pas dépasser 50 caractères");
    }

    if (empty($data['referentiel_id'] ?? '')) {
        setFieldError('referentiel_id', "Le référentiel est obligatoire");
    }

    // 3. Validation de la date de naissance
    if (empty($data['date_naissance'] ?? '')) {
        setFieldError('date_naissance', "La date de naissance est obligatoire");
    } elseif (!validateDate($data['date_naissance'])) {
        setFieldError('date_naissance', "Format de date invalide (AAAA-MM-JJ attendu)");
    } elseif (strtotime($data['date_naissance']) > strtotime('-16 years')) {
        setFieldError('date_naissance', "L'apprenant doit avoir au moins 16 ans");
    }

    // 4. Validation du lieu de naissance
    if (empty(trim($data['lieu_naissance'] ?? ''))) {
        setFieldError('lieu_naissance', "Le lieu de naissance est obligatoire");
    } elseif (strlen(trim($data['lieu_naissance'])) > 100) {
        setFieldError('lieu_naissance', "Le lieu de naissance ne doit pas dépasser 100 caractères");
    }

    // 5. Validation de l'adresse
    if (empty(trim($data['adresse'] ?? ''))) {
        setFieldError('adresse', "L'adresse est obligatoire");
    } elseif (strlen(trim($data['adresse'])) > 255) {
        setFieldError('adresse', "L'adresse ne doit pas dépasser 255 caractères");
    }

    // 6. Validation de l'email
    if (empty(trim($data['email'] ?? ''))) {
        setFieldError('email', "L'email est obligatoire");
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        setFieldError('email', "Format d'email invalide");
    } elseif (strlen(trim($data['email'])) > 100) {
        setFieldError('email', "L'email ne doit pas dépasser 100 caractères");
    } elseif (isEmailExist(trim($data['email']), $isUpdate ? ($data['apprenant_id'] ?? null) : null)) {
        setFieldError('email', "Cet email est déjà utilisé par un autre apprenant");
    }

    // 7. Validation du téléphone
    if (empty(trim($data['telephone'] ?? ''))) {
        setFieldError('telephone', "Le numéro de téléphone est obligatoire");
    } elseif (!preg_match('/^[0-9]{10}$/', trim($data['telephone']))) {
        setFieldError('telephone', "Le numéro doit contenir 10 chiffres");
    } elseif (isNumeroExist(trim($data['telephone']), $isUpdate ? ($data['apprenant_id'] ?? null) : null)) {
        setFieldError('telephone', "Ce numéro est déjà utilisé par un autre apprenant");
    }

    // 8. Validation de la photo (uniquement pour l'ajout ou si nouvelle photo fournie)
    if (!$isUpdate && empty($files['photo']['name'] ?? '')) {
        setFieldError('photo', "La photo de profil est obligatoire");
    }

    // Si photo fournie (ajout ou modification)
    if (empty($files['photo']['name'])) {
        setFieldError('photo', "Erreur lors du téléchargement de la photo");
    }

    return empty(getFieldErrors());
}
