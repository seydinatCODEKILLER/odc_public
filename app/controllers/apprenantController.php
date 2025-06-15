<?php
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/views/components/table/apprenant.php";
require_once ROOT_PATH . "/views/components/list/list.php";
require_once ROOT_PATH . "/views/components/list/empty.php";
require_once ROOT_PATH . "/views/components/card/card.php";
require_once ROOT_PATH . "/services/apprenant.service.php";


function apprenant()
{
    isUserLoggedIn();
    $filtered = [
        'statut' => $_GET['statut'] ?? "",
        'referentiel' => $_GET['referentiel'] ?? "",
        'search' => $_GET['search'] ?? "",
    ];
    if (isset($_GET['format'])) {
        handleExport($_GET['format']);
        return;
    }

    $apprenants = getApprenantInfos($filtered, $_GET['p'] ?? 1);
    $viewData = [
        'title' => "Admin | Apprenant",
        'stats' => getApprenantStat(),
        'filtered' => $filtered,
        'referentiels' => getAllReferentiels(),
        'apprenants' => $apprenants["data"],
        'pagination' => $apprenants["pagination"],
    ];

    if (is_request_method('POST') && isset($_POST['add_apprenant'])) {
        handleApprenantFormSubmition($viewData);
    }

    return render_view('admin/apprenant', "base.layout", $viewData);
}

function getApprenantStat(): array
{
    return [
        'retenus' => 10,
        'attente' => 5,
        'total' => getNombreApprenants(),
    ];
}

function handleExport(string $format)
{
    switch ($format) {
        case 'pdf':
            exportPdf();
            break;
        case 'excel':
            exportExcel();
            break;
        default:
            setFieldError("general", "Format d'export non supporté");
            redirect_to('/admin/apprenant');
    }
    exit;
}

function detailsApprenant($id)
{
    isUserLoggedIn();
    $absences = getInfoAbsenceByApprenant($id);
    return render_view('admin/details', "base.layout", [
        'title' => "Admin | Détails Apprenant",
        'apprenant' => getApprenantById($id),
        'stat' => getApprenantDetailStat($id),
        'modules' => getModuleByApprenant($id),
        'display_mode' => $_GET["d"] ?? "module",
        'absences' => $absences["data"],
        'pagination' => $absences["pagination"]
    ]);
}

function getApprenantDetailStat($id): array
{
    return [
        'retard' => getNombreRetardByApprenant($id),
        'presence' => getNombrePresenceByApprenant($id),
        'absence' => getNombreAbsenceByApprenant($id)
    ];
}


function handleApprenantFormSubmition(array $baseViewData)
{
    $result = addApprenantService($_POST, $_FILES);
    if ($result['success']) {
        setSuccess($result['message']);
        return redirect_to('/admin/apprenant');
    }
    $viewData = array_merge($baseViewData, [
        'errors' => $result['errors'] ?? [],
        'oldValues' => $result['oldValues'] ?? $_POST,
    ]);

    return render_view('admin/apprenant', "base.layout", $viewData);
}
