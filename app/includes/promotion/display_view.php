<div class=" items-center hidden lg:flex">
    <!-- Boutons de bascule -->
    <a href="/admin/promotion?mode=grid" class="btn <?= $display_mode === 'grid' ? 'btn-error text-white' : 'border border-gray-100 rounded text-gray-700' ?>">
        <i class="ri-dashboard-line"></i>
        <span>Grille</span>
    </a>
    <a href="/admin/promotion?mode=list" class="btn <?= $display_mode === 'list' ? 'btn-error text-white' : 'border border-gray-100 rounded text-gray-700' ?>">
        <i class="ri-list-check-3"></i>
        <span>Liste</span>
    </a>
</div>