<?php

function display_card_item($referentiel)
{
    $description = htmlspecialchars($referentiel["description"]);
    $image = htmlspecialchars($referentiel["image"]);
    $nom = htmlspecialchars($referentiel["nom"]);
    $capacite = intval($referentiel["capacite"]);

    echo <<<HTML
    <div class="p-3 rounded shadow-md bg-white">
        <img src="$image" alt="Image referentiel" class="h-48 w-full object-cover rounded-xl">
        <div class="flex flex-col gap-2 mt-4">
            <p class="font-medium text-lg text-red-500">$nom</p>
            <div class="flex flex-col gap-3">
                <span class="text-gray-600">$description</span>
                <div class="h-1 w-14 bg-red-500"></div>
            </div>
            <p class="text-md font-medium text-gray-600">Capacite : $capacite place</p>
        </div>
    </div>
    HTML;
}
