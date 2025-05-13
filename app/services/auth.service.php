<?php

function attempt_login(array $credentials): bool
{
    if (!is_request_method("POST") || !validateDataLogin($credentials)) {
        return false;
    }

    $user = credentialUser($credentials['email'], $credentials['password']);

    if (!$user) {
        setFieldError('credentials', 'Email ou mot de passe incorrect.');
        return false;
    }

    saveToSession("user", $user);
    setSuccess("Connexion réussie");
    return true;
}
