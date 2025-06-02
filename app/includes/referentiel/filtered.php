<form action="/admin/referentiel" class="w-full flex flex-col md:flex-row items-center gap-2">
    <div class="relative">
        <input name="search" type="text" value="<?= $search ?? "" ?>" class="border bg-white rounded py-2 px-8 w-64 md:w-96" placeholder="Rechercher...">
        <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
            <i class="ri-search-line"></i>
        </span>
    </div>
    <button type="submit" class="btn btn-error text-white">Rechercher</button>
    <?php if ($search): ?>
        <a href="/admin/referentiel" class="btn btn-outline"><i class="ri-refresh-line"></i></a>
    <?php endif; ?>
</form>