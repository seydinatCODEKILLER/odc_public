<?php
// src/config/routes.php

return [
    // Page de connexion (nouvelle URL)
    'login' => 'securityController@login',
    'logout' => 'securityController@logout',

    // Redirections pour les rôles
    'admin/dashboard' => 'controller@dashboardAdmin',
    'admin/promotion' => 'promotionController@promotion',
    'admin/referentiel' => 'referentielController@referentiel',

    'apprenant/dashboard' => 'apprenantController@dashboard',
    'vigile/dashboard' => 'vigileController@dashboard',

    //ErrorController
    '/404' => 'errorController@not_founds',

    '' => 'securityController@login',
];
