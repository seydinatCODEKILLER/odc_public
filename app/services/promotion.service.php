<?php

require_once ROOT_PATH . "/models/promotion.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/validations/promotion.validation.php";

function addPromotionService(array $postData, array $fileData): array
{
    // 1. Préparer les données
    $promotionData = [
        'nom' => trim($postData['nom'] ?? ''),
        'date_debut' => $postData['date_debut'] ?? '',
        'date_fin' => $postData['date_fin'] ?? '',
        'nombre_apprenants' => $postData['nombre_apprenants'] ?? 0,
        'referentiels' => $postData['referentiels'] ?? []
    ];

    // 2. Valider les données
    if (!validatePromotionData($promotionData, $fileData)) {
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
            $imagePath = uploadImage($fileData['image'], "promotions", "_promotion");
            $promotionData['image'] = $imagePath;
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
        $promotionId = createPromotion($promotionData);
        if (!$promotionId) {
            throw new Exception("Erreur lors de la création de la promotion");
        }

        // 6. Ajouter les référentiels
        foreach ($promotionData['referentiels'] as $referentielId) {
            if (!addReferentielToPromotion($promotionId, $referentielId)) {
                throw new Exception("Erreur lors de l'ajout des référentiels");
            }
        }

        return [
            'success' => true,
            'message' => 'Promotion créée avec succès',
            'promotionId' => $promotionId
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
