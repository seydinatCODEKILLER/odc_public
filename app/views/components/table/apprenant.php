<?php

function display_list_row_apprenant($apprenant)
{
    $id = $apprenant['id'];
    $status_color = colorState($apprenant['statut']);
    $photo = $apprenant["photo"];
    $matricule = $apprenant["matricule"];
    $nom = htmlspecialchars($apprenant['nom']);
    $prenom = htmlspecialchars($apprenant['prenom']);
    $adresse = $apprenant['adresse'];
    $telephone = $apprenant["telephone"];
    $referentiel = $apprenant["referentiel"];
    $statut =  ucfirst($apprenant["statut"]);

    echo <<<HTML
    <tr class="hover:bg-gray-50 font-medium text-gray-700">
        <td class="px-6 py-4 whitespace-nowrap">
            <img src="$photo" alt="Photo de $prenom $nom" class="w-12 h-12 rounded-lg object-cover">
        </td>
        <td class="px-6 py-4 whitespace-nowrap">$matricule</td>
        <td class="px-6 py-4 whitespace-nowrap">$prenom $nom</td>
        <td class="px-6 py-4 whitespace-nowrap">$adresse</td>
        <td class="px-6 py-4 whitespace-nowrap">$telephone</td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="badge badge-neutral">$referentiel</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="badge badge-soft badge-$status_color">$statut</span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right">
            <div class="dropdown dropdown-end">
                <button type="button" tabindex="0" class="btn btn-ghost btn-sm">
                    <i class="ri-more-2-fill text-gray-600 hover:text-gray-800"></i>
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-white rounded-box w-40 mt-1">
                    <li>
                        <a href="/admin/apprenant/$id" class="text-gray-700 hover:bg-gray-100">
                            <i class="ri-eye-line mr-2"></i>
                            <span>Détails</span>
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    HTML;
}
