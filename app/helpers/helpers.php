<?php


function dumpDie(mixed $data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}

function redirect_user_by_role(string $role): never
{
    $roleRoutes = [
        'admin' => '/admin/dashboard',
        'vigile' => '/teacher/dashboard',
        'apprenant' => '/student/dashboard'
    ];

    $route = $roleRoutes[$role] ?? '/login';

    redirect_to($route);
    exit;
}

function redirect_after_error(string $role): void
{
    $routes = [
        'admin' => '/admin/dashboard',
        'vigile' => '/teacher/dashboard',
        'apprenant' => '/attache/dashboard'
    ];

    if (array_key_exists($role, $routes)) {
        redirect_to($routes[$role]);
    }

    redirect_to('/login');
}

function is_valid_number($data): bool
{
    if (!is_numeric($data) || $data < 0) {
        return false;
    }
    return true;
}

function is_request_method(string $method): bool
{
    return $_SERVER["REQUEST_METHOD"] === strtoupper($method);
}

function redirect_to(string $path = '/', array $queryParams = [], int $httpCode = 302): void
{
    $url = rtrim($path, '/');

    if (!empty($queryParams)) {
        $url .= '?' . http_build_query($queryParams);
    }
    if (headers_sent()) {
        throw new RuntimeException('Headers already sent, cannot redirect');
    }
    header("Location: {$url}", true, $httpCode);
    exit;
}

function route_redirect(string $routeName, array $params = [], array $queryParams = [], int $httpCode = 302): void
{
    $routes = require ROOT_PATH . '/routes/route.web.php';

    if (!isset($routes[$routeName])) {
        throw new InvalidArgumentException("Route {$routeName} not defined");
    }

    $path = $routeName;
    foreach ($params as $key => $value) {
        $path = str_replace('{' . $key . '}', $value, $path);
    }

    redirect_to($path, $queryParams, $httpCode);
}


function render_view($view, $layoutPath, $data = [])
{
    extract($data);
    $viewFile = ROOT_PATH . "/views/pages/{$view}.php";

    if (!file_exists($viewFile)) {
        throw new Exception("View {$view} not found");
    }

    // dumpDie($viewFile);

    // Capture du contenu
    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    // Layout par défaut
    $layoutFile = ROOT_PATH . "/views/layout/{$layoutPath}.php";
    if (file_exists($layoutFile)) {
        require $layoutFile;
    } else {
        echo $content;
    }
}

function current_route_is(string $pattern): bool
{
    $currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $pattern = trim($pattern, '/');

    // Gestion des wildcards
    if (str_ends_with($pattern, '/*')) {
        $base = substr($pattern, 0, -2); // Retire '/*'
        return str_starts_with($currentPath, $base);
    }

    // Comparaison exacte
    return $currentPath === $pattern;
}

function colorState($state)
{
    switch ($state) {
        case 'active':
            return "success";
            break;
        case 'inactive':
            return "error";
            break;
        default:
            return "neutral";
            break;
    }
}

function colorBtnState($state)
{
    switch ($state) {
        case 'active':
            return "error";
            break;
        case 'inactive':
            return "success";
            break;
        default:
            return "neutral";
            break;
    }
}

function format_date(string $date): string
{
    return date('d/m/Y', strtotime($date));
}

function parsePostgresArray(string $pgArray): array
{
    $cleaned = trim($pgArray, '{}');
    if ($cleaned === '') {
        return [];
    }

    preg_match_all('/"([^"]+)"|([^,]+)/', $cleaned, $matches);

    $items = [];
    foreach ($matches[0] as $match) {
        $item = trim($match, '" ');
        if ($item !== '') {
            $items[] = $item;
        }
    }

    return $items;
}

function include_component(string $component, array $data = [])
{
    extract($data);
    include ROOT_PATH . "/views/components/{$component}.php";
}

function include_required($component, $data = [])
{
    extract($data);
    include ROOT_PATH . "/includes/{$component}.php";
}

function validateDate(string $date, string $format = 'Y-m-d'): bool
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function handleOperationResult(bool $success, string $targetStatus): void
{
    $action = $targetStatus === 'active' ? 'activée' : 'désactivée';
    $message = $success ? "Promotion $action avec succès" : "Erreur lors de l'$action";

    $success ? setSuccess($message) : setFieldError('general', $message);
}

function calculateNumderDates($dateDebut, $dateFin)
{

    $datetimeDebut = new DateTime($dateDebut);
    $datetimeFin = new DateTime($dateFin);

    $interval = $datetimeDebut->diff($datetimeFin);

    return $interval->days;
}

function displayJustifiedState($justified): string
{
    switch ($justified) {
        case true:
            return "badge badge-soft badge-success";
            break;

        default:
            return "badge badge-soft badge-error";
            break;
    }
}

function displayJustifiedTexte($justified): string
{
    switch ($justified) {
        case true:
            return "Justifier";
            break;

        default:
            return "Non justifier";
            break;
    }
}
