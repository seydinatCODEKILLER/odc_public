<div>
    <button class="btn btn-neutral" popovertarget="popover-1" style="anchor-name:--anchor-1">
        Telecharger
        <i class="ri-download-2-line"></i>
    </button>
    <ul class="dropdown menu w-52 rounded-box bg-base-100 shadow-sm"
        popover id="popover-1" style="position-anchor:--anchor-1">
        <li><a href="/admin/apprenant/?format=pdf&<?= http_build_query($_GET) ?>" class="text-red-500 font-medium text-md"><i class="ri-file-pdf-2-line"></i> Format PDF</a></li>
        <li><a href="/admin/apprenant/?format=excel&<?= http_build_query($_GET) ?>" class="text-green-500 font-medium text-md"><i class="ri-file-excel-2-line"></i> Format Excel</a></li>
    </ul>
</div>
<a class="btn btn-error text-white">
    Nouvelle apprenant
    <i class="ri-add-line"></i>
</a>