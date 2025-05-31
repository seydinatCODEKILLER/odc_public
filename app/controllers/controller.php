<?php

/**
 * Dashboard admin
 */
function dashboardAdmin()
{
    isUserLoggedIn();
    return render_view('admin/dashboard', "base.layout", [
        'title' => 'Tableau de bord',
        'success' => getSuccess(),
    ]);
}
