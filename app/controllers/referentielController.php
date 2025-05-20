<?php

require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/models/session.model.php";
require_once ROOT_PATH . "/services/referentiel.service.php";
require_once ROOT_PATH . "/views/components/card/card.referentiel.php";

function referentiel()
{
    isUserLoggedIn();
    $filtered = ['search' => $_GET["search"] ?? ""];

    $baseViewData = [
        'title' => 'Referentiels',
        'referentiels' => getAllReferentielsPaginated($filtered, $_GET['p'] ?? 1),
        'sessions' => getAllSessions(),
        'success' => getSuccess()
    ];

    if (is_request_method('POST') && isset($_POST['add_referentiel'])) {
        return handleReferentielFormSubmission($baseViewData);
    }

    return render_view('admin/referentiel', "base.layout", $baseViewData);
}

function handleReferentielFormSubmission(array $baseViewData)
{
    $result = addReferentielService($_POST, $_FILES);
    if ($result['success']) {
        setSuccess($result['message']);
        return redirect_to('/admin/referentiel');
    }

    $viewData = array_merge($baseViewData, [
        'errors' => $result['errors'] ?? [],
        'oldValues' => $result['oldValues'] ?? $_POST,
        'title' => 'Referentiel'
    ]);

    return render_view('admin/referentiel', "base.layout", $viewData);
}
