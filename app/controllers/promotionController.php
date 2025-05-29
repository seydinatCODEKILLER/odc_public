<?php

require_once ROOT_PATH . "/models/promotion.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/services/promotion.service.php";
require_once ROOT_PATH . "/views/components/card/card.php";
require_once ROOT_PATH . "/views/components/modals/confirmation.modal.php";


/**
 * Promotion admin
 */
function promotion()
{
    isUserLoggedIn();
    $filtered = [
        'search' => $_GET["search"] ?? "",
        'statut' => $_GET['statut'] ?? ""
    ];

    $viewData = [
        'title' => 'Promotions',
        'stats' => getPromotionStats(),
        'promotions' => getAllPromotionsWithReferentiels($filtered, $_GET['p'] ?? 1),
        'referentiels' => getAllReferentiels(),
        'filtered' => $filtered,
        'display_mode' => $_GET['mode'] ?? 'grid',
        'success' => getSuccess(),
    ];

    if (is_request_method('POST') && isset($_POST['add_promotion'])) {
        handlePromotionFormSubmition($viewData);
    }

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

function handlePromotionFormSubmition(array $baseViewData)
{
    $result = addPromotionService($_POST, $_FILES);
    if ($result['success']) {
        setSuccess($result['message']);
        return redirect_to('/admin/promotion');
    }
    $viewData = array_merge($baseViewData, [
        'errors' => $result['errors'] ?? [],
        'oldValues' => $result['oldValues'] ?? $_POST,
    ]);

    return render_view('admin/promotion', "base.layout", $viewData);
}

function toggleStatus($promotionId)
{
    $currentStatus = getPromotionStatus($promotionId);
    $newStatus = $currentStatus === 'active' ? 'inactive' : 'active';

    $success = $newStatus === 'active'
        ? desactivateAllPromotions() && setPromotionStatus($promotionId, 'active')
        : setPromotionStatus($promotionId, 'inactive');

    handleOperationResult($success, $newStatus);
    redirect_to('/admin/promotion');
}
