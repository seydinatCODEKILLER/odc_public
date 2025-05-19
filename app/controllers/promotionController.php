<?php

require_once ROOT_PATH . "/models/promotion.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/services/promotion.service.php";
require_once ROOT_PATH . "/views/components/card/card.php";

/**
 * Promotion admin
 */
function promotion()
{
    isUserLoggedIn();

    if (is_request_method('POST') && isset($_POST['add_promotion'])) {
        $result = addPromotionService($_POST, $_FILES);

        if ($result['success']) {
            setSuccess($result['message']);
            return redirect_to('/admin/promotion');
        }

        $viewData = [
            'title' => 'Promotions',
            'success' => getSuccess(),
            'errors' => $result['errors'] ?? [],
            'oldValues' => $result['oldValues'] ?? $_POST,
            'promotions' => getAllPromotionsWithReferentiels([], $_GET['p'] ?? 1),
            'referentiels' => getAllReferentiels(),
            'stats' => getPromotionStats(),
            'display_mode' => $_GET['mode'] ?? 'grid'
        ];

        return render_view('admin/promotion', "base.layout", $viewData);
    }

    $viewData = [
        'title' => 'Promotions',
        'stats' => getPromotionStats(),
        'promotions' => getAllPromotionsWithReferentiels([], $_GET['p'] ?? 1),
        'referentiels' => getAllReferentiels(),
        'display_mode' => $_GET['mode'] ?? 'grid'
    ];

    return render_view('admin/promotion', "base.layout", $viewData);
}

function getPromotionStats(): array
{
    return [
        'nombre_promotions' => getNombrePromotions(),
        'nombre_promotions_active' => getNombrePromotionsActives(),
        'nombre_referentiel' => getNombreReferentiels(),
        'nombre_apprenant' => getNombreApprenants()
    ];
}
