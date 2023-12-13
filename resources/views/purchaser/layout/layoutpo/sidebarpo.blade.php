<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar border-end collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <!-- <li class="nav-item ">
                <a class="nav-link {{ Request::is('sales/dashboard/salesIndexCrm') ? 'bg-danger rounded' : '' }}" href="/purchaseorder/dashboard">
                    <i class="bi bi-grid-fill"></i>
                    Dashboard
                </a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('purchaseorder') ? 'bg-danger text-white active rounded' : 'fw=normal' }}" href="/purchaseorder">
                <i class="bi bi-bag-fill"></i>
                    Purchase Order
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('reportpo') ? 'bg-danger text-white active rounded' : 'fw-normal' }}" href="/reportpo">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    Report
                </a>
            </li>
        </ul>
    </div>
</nav>

