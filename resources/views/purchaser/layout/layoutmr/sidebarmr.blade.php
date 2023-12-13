<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar border-end collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <!-- <li class="nav-item ">
                <a class="nav-link {{ Request::is('sales/dashboard/salesIndexCrm') ? 'text-white active rounded' : '' }}" href="/materialrequest/dashboard">
                    <i class="bi bi-grid-fill"></i>
                    Dashboard
                </a>
            </li> -->
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('materialrequest') ? 'bg-danger text-white active rounded' : 'fw=normal' }}" href="/materialrequest">
                    <i class="bi bi-people-fill"></i>
                    Material Request
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{ Request::is('reportmr') ? 'bg-danger text-white active rounded' : 'fw-normal' }}" href="/reportmr">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    Report
                </a>
            </li>
        </ul>
    </div>
</nav>