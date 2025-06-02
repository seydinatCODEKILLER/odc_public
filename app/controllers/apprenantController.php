<?php
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/models/referentiel.model.php";
require_once ROOT_PATH . "/views/components/table/apprenant.php";

function apprenant()
{
    isUserLoggedIn();
    $filtered = [
        'statut' => $_GET['statut'] ?? "",
        'referentiel' => $_GET['referentiel'] ?? "",
        'search' => $_GET['search'] ?? "",
    ];
    $apprenants = getApprenantInfos($filtered, $_GET['p'] ?? 1);
    return render_view('admin/apprenant', "base.layout", [
        'title' => "Admin | Apprenant",
        'stats' => getApprenantStat(),
        'filtered' => $filtered,
        'referentiels' => getAllReferentiels(),
        'apprenants' => $apprenants["data"],
        'pagination' => $apprenants["pagination"],
    ]);
}

function getApprenantStat()
{
    return [
        'retenus' => 10,
        'attente' => 5,
        'total' => getNombreApprenants(),
    ];
}
