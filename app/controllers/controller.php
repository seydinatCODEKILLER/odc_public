<?php

/**
 * Dashboard admin
 */
function dashboardAdmin()
{
    isUserLoggedIn();
    return render_view('admin/dashboard', "base.layout", [
        'title' => 'Admin | Dashboard',
        'success' => getSuccess(),
    ]);
}
