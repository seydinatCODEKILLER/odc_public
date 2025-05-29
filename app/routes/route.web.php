<?php

/**
 * Gère la requête entrante et appelle le bon contrôleur
 */
function handle_request()
{
    try {
        // Chargement des routes
        $routes = require ROOT_PATH . "/config/route.php";
        // dumpDie($routes);

        // Nettoyage de l'URL
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = trim($url, '/');
        // dumpDie($url);

        // Recherche de correspondance avec les routes définies
        foreach ($routes as $route => $handler) {
            $pattern = create_route_pattern($route);
            // dumpDie($pattern);

            if (preg_match($pattern, $url, $matches)) {
                list($controller, $action) = explode('@', $handler);
                // dumpDie($controller, $action);
                $params = array_slice($matches, 1);
                // dumpDie($params);


                return call_controller($controller, $action, $params);
            }
        }

        // Aucune route trouvée
        return not_found();
    } catch (Exception $e) {
        return server_error($e->getMessage());
    }
}

/**
 * Crée un pattern regex à partir d'une route
 */
function create_route_pattern($route)
{
    // Version avec typage optionnel {id:int}
    $pattern = preg_replace_callback('/\{([a-z]+)(:int)?\}/', function ($matches) {
        return isset($matches[2]) ? '(\d+)' : '([^\/]+)';
    }, $route);

    return '#^' . $pattern . '$#i';
}

/**
 * Appelle un contrôleur et une action spécifique
 */
function call_controller($controller, $action, $params = [])
{
    $controllerFile = ROOT_PATH . "/controllers/{$controller}.php";

    // Vérification du contrôleur
    if (!file_exists($controllerFile)) {
        throw new Exception("Controller {$controller} not found");
    }

    // dumpDie($controllerFile);
    require_once $controllerFile;

    // Vérification de l'action
    if (!function_exists($action)) {
        throw new Exception("Action {$action} not found in {$controller}");
    }

    // dumpDie($action);

    // Appel du contrôleur avec les paramètres
    return $action(...$params);
}

/**
 * Gestion des erreurs
 */
function not_found()
{
    http_response_code(404);
    return call_controller('errorController', 'not_founds');
}

function server_error($message)
{
    http_response_code(500);
    return call_controller('errorController', 'server_error', [$message]);
}
