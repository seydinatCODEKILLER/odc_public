<?php

require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/models/session.model.php";
require_once ROOT_PATH . "/services/referentiel.service.php";
require_once ROOT_PATH . "/views/components/card/card.referentiel.php";


function referentiel()
{
    isUserLoggedIn();

    if (is_request_method('POST') && isset($_POST['add_referentiel'])) {
        $result = addReferentielService($_POST, $_FILES);

        if ($result['success']) {
            setSuccess($result['message']);
            return redirect_to('/admin/referentiel');
        }

        $viewData = [
            'title' => 'Referentiel',
            'success' => getSuccess(),
            'errors' => $result['errors'] ?? [],
            'oldValues' => $result['oldValues'] ?? $_POST,
            'referentiels' => getAllReferentielsPaginated([], $_GET['p'] ?? 1),
            'sessions' => getAllSessions()
        ];

        return render_view('admin/referentiel', "base.layout", $viewData);
    }

    $viewData = [
        'title' => 'Referentiels',
        'referentiels' => getAllReferentielsPaginated([], $_GET['p'] ?? 1),
        'sessions' => getAllSessions()
    ];

    return render_view('admin/referentiel', "base.layout", $viewData);
}
