<?php

function display_stat_card($value, $label, $icon, $bg_color = 'error')
{
    echo <<<HTML
    <div class="bg-$bg_color text-white rounded shadow-sm flex items-center justify-between gap-4 p-5">
        <div class="flex flex-col">
            <p class="font-medium text-4xl">$value</p>
            <span class="text-md font-medium">$label</span>
        </div>
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-red-500">
            <i class="$icon text-2xl"></i>
        </div>
    </div>
    HTML;
}
