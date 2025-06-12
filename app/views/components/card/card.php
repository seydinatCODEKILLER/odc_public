<?php

function display_stat_card($value, $label, $icon, $bg_color = 'error')
{
    // Définition des dégradés de couleur en fonction de bg_color
    $gradients = [
        'error' => 'bg-gradient-to-r from-red-500 to-pink-500',
        'success' => 'bg-gradient-to-r from-green-500 to-teal-500',
        'warning' => 'bg-gradient-to-r from-yellow-500 to-orange-500',
        'info' => 'bg-gradient-to-r from-blue-500 to-cyan-500',
        'primary' => 'bg-gradient-to-r from-purple-500 to-indigo-500',
        'white' => 'bg-gradient-to-r from-blue-500 to-white-500'
    ];

    $gradient = $gradients[$bg_color] ?? $gradients['error'];

    echo <<<HTML
    <div class="$gradient text-white rounded-lg shadow-lg flex items-center justify-between gap-4 p-6 
                transition-all duration-300 transform hover:scale-105 hover:shadow-xl cursor-pointer">
        <div class="flex flex-col">
            <p class="font-bold text-4xl animate-pulse-on-hover">$value</p>
            <span class="text-md font-medium opacity-90">$label</span>
        </div>
        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center 
                    text-white border-2 border-white/30 transition-all duration-300 hover:rotate-12">
            <i class="$icon text-2xl"></i>
        </div>
    </div>
    
    <style>
        .animate-pulse-on-hover {
            animation: none;
        }
        .animate-pulse-on-hover:hover {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
    HTML;
}

function display_grid_item($promotion)
{
    $id = $promotion["promotion_id"];
    $status_color = colorState($promotion["statut"]);
    $btn_color = colorBtnState($promotion["statut"]);
    $date_debut = format_date($promotion["date_debut"]);
    $date_fin = format_date($promotion["date_fin"]);
    $image = htmlspecialchars($promotion["image"]);
    $nom = htmlspecialchars($promotion["promotion_nom"]);
    $statut = htmlspecialchars($promotion["statut"]);
    $nb_apprenants = intval($promotion["nombre_apprenants"]);

    echo <<<HTML
    <div class="p-3 rounded shadow-md bg-white hover:shadow-lg transition-all duration-300">
        <!-- Statut + Bouton -->
        <div class="flex justify-end items-center gap-3">
            <span class="badge badge-soft badge-$status_color font-medium text-md">$statut</span>
            <button id="btnstate" onclick="confirmToggleStatus($id, '$statut')" 
                    class="btn btn-soft btn-$btn_color w-10 h-10 rounded-full flex justify-center items-center">
                <i class="ri-shut-down-line"></i>
            </button>
        </div>

        <!-- Image + Nom + Dates -->
        <div class="mt-2 flex items-center gap-3">
            <img src="$image" class="w-12 h-12 rounded-full object-cover" alt="Image promotion">
            <div class="flex flex-col">
                <p class="font-medium text-lg">$nom</p>
                <span class="text-gray-500 font-medium">
                    <i class="ri-calendar-line"></i> $date_debut - $date_fin
                </span>
            </div>
        </div>

        <!-- Nombre d'apprenants -->
        <div class="mt-4 p-2 rounded bg-gray-50 flex items-center gap-3 text-gray-800 font-medium">
            <i class="ri-group-line"></i>
            <span>$nb_apprenants apprenants</span>
        </div>

        <!-- Lien voir détails -->
        <div class="flex justify-end mt-5 border-t-2 border-gray-200">
            <a href="#" class="text-red-500 py-2 flex items-center gap-1">
                <span>Voir détails</span>
                <i class="ri-arrow-right-s-line"></i>
            </a>
        </div>
    </div>

    HTML;
}

function display_list_row($promotion)
{
    $status_color = colorState($promotion['statut']);
    $date_debut = format_date($promotion["date_debut"]);
    $date_fin = format_date($promotion["date_fin"]);
    $nom = htmlspecialchars($promotion['promotion_nom']);
    $nb_apprenants = intval($promotion['nombre_apprenants']);
    $referentiels = parsePostgresArray($promotion["referentiels"]);
    $statut = $promotion["statut"];

    echo <<<HTML
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap font-medium">$nom</td>
        <td class="px-6 py-4 whitespace-nowrap">$date_debut</td>
        <td class="px-6 py-4 whitespace-nowrap">$date_fin</td>
        <td class="px-6 py-4 whitespace-nowrap">$nb_apprenants</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex flex-wrap gap-2">
    HTML;

    foreach ($referentiels as $ref) {
        $ref_safe = htmlspecialchars($ref);
        echo <<<HTML
        <span class="badge badge-soft badge-primary text-sm font-medium">$ref_safe</span>
        HTML;
    }

    echo <<<HTML
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="badge badge-soft badge-$status_color">$statut</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right">
            <div class="dropdown dropdown-end">
                <button type="button" tabindex="0" class="btn btn-ghost btn-sm">
                    <i class="ri-more-2-fill text-gray-400 hover:text-gray-600"></i>
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-white rounded-box w-40 mt-1">
                    <li>
                        <a href="" class="text-gray-700 hover:bg-gray-100">
                            <i class="ri-pencil-line text-gray-400"></i>action
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    HTML;
}

function display_grid_module($module)
{
    $status_color = colorState($module["statut"]);
    $jours = calculateNumderDates($module["date_debut"], $module["date_fin"]);
    $status = colorState($module["statut"]);
    $date_debut = format_date($module["date_debut"]);
    $date_fin = format_date($module["date_fin"]);
    $nom = htmlspecialchars($module["nom"]);
    $description = htmlspecialchars($module["description"]);

    echo <<<HTML
    <div class="flex flex-col gap-2 p-3 rounded bg-white shadow-lg">
        <div class="flex items-center justify-between">
            <span class="badge badge-neutral font-medium text-xs"><i class="ri-time-line"></i> $jours jours</span>
            <span class="px-3 py-1 rounded shadow-sm cursor-pointer"><i class="ri-equalizer-line"></i></span>
        </div>
        <div class="flex flex-col">
            <p class="font font-medium text-lg">$nom</p>
            <span class="text-gray-600 text-xs font-medium">$description</span>
            <span class="badge badge-soft badge-$status_color mt-3">$status</span>
        </div>
        <div class="p-2 bg-gray-50 flex items-center justify-between mt-4">
            <div class="flex items-center gap-2">
                <div class="flex items-center text-orange-500 justify-center w-10 h-10 rounded-full bg-white shadow-sm"><i class="ri-timer-flash-line"></i></div>
                <div class="flex flex-col text-xs font-medium">
                    <span>Debut :</span>
                    <span>$date_debut</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center text-blue-500 justify-center w-10 h-10 rounded-full bg-white shadow-sm"><i class="ri-hourglass-fill"></i></div>
                    <div class="flex flex-col text-xs font-medium">
                        <span>Fin :</span>
                        <span>$date_fin</span>
                    </div>
                </div>
        </div>
    </div>

    HTML;
}

function display_list_absence($absences)
{
    $date_absence = format_date($absences['date_absence']);
    $heure_absence = $absences["heure_absence"];
    $is_justified = displayJustifiedTexte($absences["is_justified"]);
    $is_justified_color = displayJustifiedState($absences["is_justified"]);
    $module = htmlspecialchars($absences['module']);

    echo <<<HTML
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap font-medium">$module</td>
        <td class="px-6 py-4 whitespace-nowrap font-medium">$date_absence</td>
        <td class="px-6 py-4 whitespace-nowrap">$heure_absence</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="$is_justified_color font-medium">$is_justified</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right">
            <div class="dropdown dropdown-end">
                <button type="button" tabindex="0" class="btn btn-ghost btn-sm">
                    <i class="ri-more-2-fill text-gray-400 hover:text-gray-600"></i>
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-white rounded-box w-40 mt-1">
                    <li>
                        <a class="text-gray-700 hover:bg-gray-100">
                            <i class="ri-pencil-line text-gray-400"></i>action
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    HTML;
}
