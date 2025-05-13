
<?php

function isUserLoggedIn()
{
    if (!getDataFromSession("user")) {
        redirect_to('/login');
        exit();
    };
}

function isLogged()
{
    if (getDataFromSession("user")) {
        redirect_user_by_role(getDataFromSession("user", "libelle"));
        exit;
    }
}

function credentialUser(string $email, string $password): array|null
{
    $sql = "
    SELECT u.nom, u.id, u.nom, u.avatar,u.email, r.libelle
    FROM utilisateur u
    JOIN role r ON r.id = u.role_id
    WHERE u.email = ? AND u.mot_de_passe = ?";
    $params = [$email, $password];
    $user = fetchResult($sql, $params, false);
    return $user ?: null;
}
