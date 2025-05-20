<div
    id="sidebar"
    class="flex flex-col justify-between p-3 fixed left-0 shadow-md h-full bg-white text-gray-900 w-64 lg:w-52 md:flex transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 z-50">
    <div class="flex flex-col gap-6">
        <div class="flex justify-between">
            <div class="flex items-center gap-2 text-md">
                <img src="../assets/images/logo.png" alt="" class="h-7 object-cover">
                <div class="flex flex-col">
                    <h1 class="text-xs font-medium text-gray-900">Ecole 221</h1>
                    <p class="text-sm text-red-500 font-medium">Future is now</p>
                </div>
            </div>
            <div class="lg:hidden" id="sidebar-close">
                <i class="ri-layout-right-line text-lg font-semibold"></i>
            </div>
        </div>
        <nav>
            <ul class="flex flex-col gap-1">
                <li class="py-2 px-4 <?= current_route_is("/admin/dashboard") ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white rounded' : 'hover:bg-gray-50' ?> ">
                    <a
                        href="<?= ROOT_URL ?>admin/dashboard"
                        class="font-medium gap-3 flex items-center text-sm">
                        <i class="ri-home-3-line text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="py-2 px-4 <?= current_route_is("/admin/promotion") ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white rounded' : 'hover:bg-gray-50' ?> ">
                    <a
                        href="<?= ROOT_URL ?>admin/promotion"
                        class="font-medium gap-3 flex items-center text-sm">
                        <i class="ri-archive-line text-lg"></i>
                        <span>Promotions</span>
                    </a>
                </li>
                <li class="py-2 px-4 <?= current_route_is("/admin/referentiel") ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white rounded' : 'hover:bg-gray-50' ?> ">
                    <a
                        href="<?= ROOT_URL ?>admin/referentiel"
                        class="font-medium gap-3 flex items-center text-sm">
                        <i class="ri-presentation-line text-lg"></i>
                        <span>Referentiels</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="">
        <a href="<?= ROOT_URL ?>logout" class="btn rounded w-full">
            <i class="ri-logout-box-r-line font-medium"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</div>