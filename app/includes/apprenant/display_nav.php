<div class="flex border-b-2 border-red-500 text-red-500 items-center justify-center">
    <a href="/admin/apprenant?statut=retenus"
        class="tab-button px-4 py-2 font-medium ">
        Liste des apprenants retenus (<span id="countRetenus"><?= $stats["retenus"] ?></span>)
    </a>
</div>
<div class="flex justify-center items-center bg-gray-50">
    <a
        class="tab-button px-4 py-2 font-medium text-gray-500">
        Liste des apprenant en attente (<span id="countAttente"><?= $stats["attente"] ?></span>)
    </a>
</div>