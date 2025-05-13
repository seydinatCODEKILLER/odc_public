<?php
function not_founds()
{
    http_response_code(404);
    return render_view('errors/404', "security.layout", [
        'title' => 'Page non trouvée',
        'message' => 'La page que vous recherchez n\'existe pas ou a été déplacée.'
    ]);
}
