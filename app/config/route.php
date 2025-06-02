<?php

return [
    // Authentication routes
    'login' => 'securityController@login',
    'logout' => 'securityController@logout',

    // Admin routes
    'admin/dashboard' => 'controller@dashboardAdmin',
    'admin/promotion' => 'promotionController@promotion',
    'admin/promotion/{id}/toggle-status' => 'promotionController@toggleStatus',
    'admin/referentiel' => 'referentielController@referentiel',
    'admin/apprenant' => 'apprenantController@apprenant',
    'admin/apprenants/export' => 'apprenantController@export',

    //Erreur routes
    '404' => 'errorController@not_founds',

    //Default routes
    '' => 'securityController@login',
];
