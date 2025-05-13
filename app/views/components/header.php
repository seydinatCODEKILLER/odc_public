<div class="flex justify-between items-center px-4 py-3 bg-white rounded shadow-sm">
    <div class="hidden md:block">
        <form action="">
            <div class="relative">
                <input type="text" class="border bg-gray-50 rounded py-2 px-8 w-96 focus:outline-none focus:ring focus:ring-red-500" placeholder="Rechercher...">
                <button type="submit" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="w-10 h-10 bg-gray-50 flex justify-center items-center rounded-full lg:hidden" id="sidebar-device"><i class="ri-apps-2-line"></i></div>
    <div class="flex items-center gap-6">
        <span class="text-lg"><i class="ri-notification-3-line"></i></span>
        <div class="flex items-center gap-2">
            <img src="<?= getDataFromSession("user", "avatar") ?>" alt="" class="w-9 h-9 rounded-full object-cover cursor-pointer ">
            <div class="flex flex-col">
                <span class="text-sm text-start text-purple-500 font-medium"><?= getDataFromSession("user", "email") ?></span>
                <span class="text-xs font-medium"><?= getDataFromSession("user", "libelle") ?></span>
            </div>
        </div>
    </div>

</div>