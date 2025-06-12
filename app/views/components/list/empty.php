<?php

function display_empty_table(string $linkImage, string $message, int $colonne)
{
    echo <<<HTML
    <tr>
        <td colspan="$colonne" class="px-6 py-4 text-center">
            <div class="flex flex-col items-center justify-center gap-4">
                <img src="$linkImage" alt="Aucun image" class="">
                <div class="text-gray-500 text-sm font-medium">
                    $message
                </div>
            </div>
        </td>
    </tr>
    HTML;
}
