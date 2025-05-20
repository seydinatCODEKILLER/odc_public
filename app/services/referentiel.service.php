<?php

require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/validations/referentiel.validation.php";

function addReferentielService(array $postData, array $fileData): array
{
    // 1. Préparer les données
    $referentielData = [
        'nom' => trim($postData['nom'] ?? ''),
        'description' => $postData['description'] ?? '',
        'session' => $postData['session'] ?? '',
        'capacite' => $postData['capacite'] ?? 0,
    ];


    // 2. Valider les données
    if (!validateReferentielsData($referentielData, $fileData)) {
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => getFieldErrors()
        ];
    }

    // 3. Uploader l'image
    $imagePath = null;
    if (!empty($fileData['image']['name'])) {
        try {
            $imagePath = uploadImage($fileData['image'], "referentiels", "_referentiel");
            $referentielData['image'] = $imagePath;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => ['image' => $e->getMessage()]
            ];
        }
    }

    try {
        // 5. Créer la promotion
        $refId = createReferentiel($referentielData);

        return [
            'success' => true,
            'message' => 'Promotion créée avec succès',
            'promotionId' => $refId
        ];
    } catch (Exception $e) {

        // Supprimer l'image uploadée si la transaction échoue
        if ($imagePath && file_exists(ROOT_PATH_UPLOAD . $imagePath)) {
            unlink(ROOT_PATH_UPLOAD . $imagePath);
        }

        return [
            'success' => false,
            'message' => $e->getMessage(),
            'errors' => ['general' => $e->getMessage()]
        ];
    }
}
