<?php

require_once ROOT_PATH . "/services/auth.service.php";


/**
 * Gère la page de connexion
 */
function login()
{
    // Vérification si déjà connecté
    isLogged();
    clearFieldErrors();

    if (attempt_login($_POST)) {
        redirect_user_by_role(getDataFromSession("user", "libelle"));
        return;
    }
    render_view('auth/login', "security.layout", [
        'title' => 'Connexion'
    ]);
}

/**
 * Gère la déconnexion
 */
function logout()
{
    session_unset();
    session_destroy();
    return redirect_to('/login');;
}
