<div class="flex <?= $display_mode == "module" ? "bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg rounded" : "bg-gray-50 border border-gray-200" ?> items-center justify-center">
    <a href="/admin/apprenant/<?= $apprenant["id"] ?>?d=module"
        class="tab-button px-4 py-2 font-medium ">
        Programmes & Modules
    </a>
</div>
<div class="flex justify-center items-center <?= $display_mode == "absence" ? "bg-gradient-to-r from-red-500 to-pink-500 text-white shadow-lg rounded" : "bg-gray-50 border border-gray-200" ?>">
    <a
        href="/admin/apprenant/<?= $apprenant["id"] ?>?d=absence"
        class="tab-button px-4 py-2 font-medium">
        Liste des absences par etudiants
    </a>
</div>