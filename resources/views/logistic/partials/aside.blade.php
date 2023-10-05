 <aside class="main-sidebar sidebar-light-light elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
         {{-- <img src=""  class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
         <span class="brand-text font-weight-light">Trafoindo</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-item">
                     <a href="{{ url('logistic') }}" class="nav-link active">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item ">
                     <a href="" class="nav-link }}">
                         <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 37 36"
                             fill="none">
                             <path
                                 d="M2 7.21692V17.6507C2 17.6507 2 22.8676 15.4797 22.8676C28.9593 22.8676 28.9593 17.6507 28.9593 17.6507V7.21692"
                                 stroke="black" stroke-opacity="0.7" stroke-width="4" stroke-linecap="round"
                                 stroke-linejoin="round" />
                             <path
                                 d="M15.4797 2C28.9593 2 28.9593 7.2169 28.9593 7.2169C28.9593 7.2169 28.9593 12.4338 15.4797 12.4338C2 12.4338 2 7.2169 2 7.2169C2 7.2169 2 2 15.4797 2Z"
                                 stroke="black" stroke-opacity="0.7" stroke-width="4" stroke-linecap="round"
                                 stroke-linejoin="round" />
                             <path d="M15.4797 33.3013C2 33.3013 2 28.0844 2 28.0844V17.6506" stroke="black"
                                 stroke-opacity="0.7" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                             <path d="M23.1823 33.3013V29.8234" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                 stroke-linecap="round" />
                             <path d="M28.9593 33.3014V26.3456" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                 stroke-linecap="round" />
                             <path d="M34.7363 33.3014V22.8676" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                 stroke-linecap="round" />
                         </svg>
                         <p>
                             Data master
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href={{ url('material') }} class="nav-link }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Material</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href={{ url('drytype') }} class="nav-link }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Gudang RM Dry Type</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ URL('ctvt') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Gudang RM CTVT</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ url('oil') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Gudang RM Oil</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-solid fa-box"></i>
                         <p>
                             Receiving
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ url('incoming') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Kedatangan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ url('bpnb') }}" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>BPNP</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index3.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Scan</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-solid fa-warehouse"></i>
                         <p>
                             Storage
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="./index.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Storage 1</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index2.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Storage 2</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index3.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Storage 3</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-solid fa-box-open"></i>
                         <p>
                             Picking
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="./index.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Picking 1</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index2.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Picking 2</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index3.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Picking 3</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon fas fa-solid fa-truck"></i>
                         <p>
                             Shipping
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="./index.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Shipping 1</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index2.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Shipping 2</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="./index3.html" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Shipping 3</p>
                             </a>
                         </li>
                     </ul>
                 </li>
             </ul>
         </nav>
     </div>
 </aside>
