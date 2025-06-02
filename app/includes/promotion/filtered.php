 <form action="/admin/promotion" class="w-full flex items-center flex-col md:flex-row gap-3">
     <div class="flex items-center">
         <div class="relative">
             <input type="text" name="search" class="border rounded py-2 px-8 lg:w-[500px] bg-white" placeholder="Rechercher...">
             <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                 <i class="ri-search-line"></i>
             </span>
         </div>
         <select class="select border-0 bg-white" name="statut">
             <option value="">Tous</option>
             <option value="active">Active</option>
             <option value="inactive">Inactive</option>
         </select>
     </div>
     <div class="flex items-center">
         <button type="submit" class="btn btn-error text-white">
             <i class="ri-search-line"></i> Filtrez
         </button>
         <?php if (!empty($filtered["search"]) || !empty($filtered["statut"])): ?>
             <a href="/admin/promotion" class="btn btn-outline"><i class="ri-refresh-line"></i></a>
         <?php endif; ?>
     </div>
 </form>