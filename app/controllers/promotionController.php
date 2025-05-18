<?php

require_once ROOT_PATH . "/models/promotion.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/views/components/card/card.php";

/**
 * Promotion admin
 */
function promotion()
{
    isUserLoggedIn();
    $display_mode = $_GET['mode'] ?? 'grid';
    $stats = [
        'nombre_promotions' => getNombrePromotions(),
        'nombre_promotions_active' => getNombrePromotionsActives(),
        'nombre_referentiel' => getNombreReferentiels(),
        'nombre_apprenant' => getNombreApprenants(),
        'promotions' => getAllPromotionsWithReferentiels()
    ];
    return render_view('admin/promotion', "base.layout", [
        'title' => 'Promotions',
        'stats' => $stats,
        'display_mode' => $display_mode
    ]);
}
