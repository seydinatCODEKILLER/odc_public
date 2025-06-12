<?php

function display_list(string $icon, string $data, string $color)
{
    echo <<<HTML
    <div class="badge badge-soft badge-$color font-medium text-md flex items-center gap-4">
        <i class="$icon"></i>
        <span>$data</span>
    </div>
    HTML;
}
