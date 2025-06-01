<?php

function apprenant()
{
    isUserLoggedIn();
    return render_view('admin/apprenant', "base.layout", [
        'title' => "Admin | Apprenant",
    ]);
}
