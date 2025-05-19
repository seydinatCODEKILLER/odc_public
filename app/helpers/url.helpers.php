<?php

/**
 * Génère une URL absolue pour une route nommée
 * 
 * @param string $path Chemin ou nom de route
 * @param array $params Paramètres de route
 * @param array $queryParams Paramètres de query string
 * @return string URL absolue
 */
function url_for(string $path, array $params = [], array $queryParams = []): string
{
    static $routes = null;

    // Charger les routes une seule fois
    if ($routes === null) {
        $routes = require ROOT_PATH . '/config/route.php';
    }

    // Si le chemin commence par /, c'est une URL directe
    if (strpos($path, '/') === 0) {
        return build_url($path, $queryParams);
    }

    // Trouver la route correspondante
    if (isset($routes[$path])) {
        $routePattern = $routes[$path];
        return build_url(replace_route_params($routePattern, $params), $queryParams);
    }

    // Si la route n'est pas trouvée, générer une URL avec le chemin tel quel
    return build_url($path, $queryParams);
}

/**
 * Remplace les paramètres dans le pattern de route
 */
function replace_route_params(string $routePattern, array $params): string
{
    return preg_replace_callback('/\{([a-z]+)\}/', function ($matches) use ($params) {
        $paramName = $matches[1];
        return $params[$paramName] ?? $matches[0]; // Retourne le paramètre ou le pattern original si non trouvé
    }, $routePattern);
}

/**
 * Construit l'URL finale avec les query params
 */
function build_url(string $path, array $queryParams = []): string
{
    $url = ROOT_URL . '/' . ltrim($path, '/');

    if (!empty($queryParams)) {
        $url .= '?' . http_build_query($queryParams);
    }

    return $url;
}
