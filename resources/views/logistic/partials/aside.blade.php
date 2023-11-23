 <aside class="main-sidebar sidebar-light-light elevation-4">
     <!-- Brand Logo -->

     <a href="{{ url('logistic') }}" class="brand-link">
         <span class="brand-text font-weight-light pl-3"><img src="{{ asset('/') }}assets/dist/img/logo-trafo.png"
                 class="brand-image" style="opacity: .8, text-align: center">
         </span>
     </a>


     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!--Dashboard -->
                 <li class="nav-item">
                     <a href="{{ url('logistic') }}"
                         class="nav-link {{ request()->segment(1) == 'logistic' ? 'active' : '' }}">
                         <i class="nav-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 36 36"
                                 fill="none">
                                 <g clip-path="url(#clip0_2347_1890)">
                                     <path
                                         d="M18.0001 4.25001C14.8528 4.24641 11.7702 5.14355 9.11643 6.83548C6.46261 8.52742 4.34841 10.9435 3.02352 13.7983C1.69862 16.6531 1.21838 19.8275 1.63951 22.9465C2.06064 26.0655 3.36554 28.9988 5.40011 31.4L5.70011 31.75H30.3001L30.6001 31.4C32.6347 28.9988 33.9396 26.0655 34.3607 22.9465C34.7818 19.8275 34.3016 16.6531 32.9767 13.7983C31.6518 10.9435 29.5376 8.52742 26.8838 6.83548C24.23 5.14355 21.1474 4.24641 18.0001 4.25001ZM26.6001 13.73L20.6801 19.54C20.9827 20.1797 21.0494 20.9057 20.8685 21.5899C20.6875 22.274 20.2706 22.8721 19.6913 23.2786C19.1121 23.685 18.4078 23.8736 17.7029 23.811C16.9981 23.7485 16.338 23.4387 15.8394 22.9366C15.3408 22.4345 15.0357 21.7722 14.9782 21.0669C14.9206 20.3617 15.1141 19.6587 15.5247 19.0823C15.9352 18.506 16.5363 18.0933 17.2216 17.9172C17.907 17.7411 18.6326 17.8129 19.2701 18.12L25.1801 12.31L26.6001 13.73ZM3.60011 19.9H7.00011V21.9H3.56011C3.56011 21.51 3.51011 21.13 3.51011 20.73C3.51011 20.33 3.53011 20.18 3.55011 19.9H3.60011ZM8.48011 9.90001L10.9401 12.36L9.47011 13.74L7.00011 11.29C7.44343 10.7842 7.92124 10.3098 8.43011 9.87001L8.48011 9.90001ZM19.0001 9.79001H17.0001V6.29001H18.0001C18.3701 6.29001 18.7001 6.29001 19.0001 6.34001V9.79001ZM32.4901 20.74C32.4901 21.13 32.4901 21.53 32.4401 21.91H28.9201V19.91H32.4501C32.4701 20.18 32.4901 20.46 32.4901 20.74Z"
                                         fill="#565151" />
                                 </g>
                                 <defs>
                                     <clipPath id="clip0_2347_1890">
                                         <rect width="36" height="36" fill="white" />
                                     </clipPath>
                                 </defs>
                             </svg>
                         </i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>

                 <!-- Data mastemaster -->
                 <li class="nav-item {{ request()->segment(1) == 'datamaster' ? 'menu-open' : '' }}">
                     <a href="" class="nav-link">
                         <i class="nav-icon">
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
                                     stroke-opacity="0.7" stroke-width="4" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path d="M23.1823 33.3013V29.8234" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                     stroke-linecap="round" />
                                 <path d="M28.9593 33.3014V26.3456" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                     stroke-linecap="round" />
                                 <path d="M34.7363 33.3014V22.8676" stroke="black" stroke-opacity="0.7" stroke-width="4"
                                     stroke-linecap="round" />
                             </svg>
                         </i>

                         <!-- Data Master -->
                         <p>
                             Data master
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item ">
                             <a href={{ url('datamaster/material') }}
                                 class="nav-link {{ request()->segment(2) === 'material' ? 'active' : '' }} ">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Material</p>
                             </a>
                         </li>
                         <li class="nav-item ">
                             <a href={{ url('datamaster/supplier') }}
                                 class="nav-link {{ request()->segment(2) === 'supplier' ? 'active' : '' }} ">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Supplier</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href={{ url('datamaster/finishedgood') }}
                                 class="nav-link {{ request()->segment(2) === 'finishedgood' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Finished good</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href={{ url('datamaster/finishedgood') }}
                                 class="nav-link {{ request()->segment(2) === 'finishedgood' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Data Finishedgood</p>
                             </a>
                         </li>
                     </ul>

                     <!-- data master end  -->
                 </li>

                 <!-- Receiving -->
                 <li class="nav-item {{ request()->segment(1) == 'receiving' ? 'menu-open' : '' }}">
                     <a href="#" class="nav-link">
                         <i class="nav-icon ">
                             <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 38 32"
                                 fill="none">
                                 <mask id="path-1-inside-1_2351_2528" fill="white">
                                     <path
                                         d="M1 8.92377L18.4283 14.9071L19.608 12.8567L2.1797 6.87341L1 8.92377ZM20.4705 30.336V13.8819H17.5658V30.336H20.4705ZM19.608 14.9071L37.0363 8.92377L35.8566 6.87341L18.4283 12.8567L19.608 14.9071Z" />
                                 </mask>
                                 <path
                                     d="M1 8.92377L18.4283 14.9071L19.608 12.8567L2.1797 6.87341L1 8.92377ZM20.4705 30.336V13.8819H17.5658V30.336H20.4705ZM19.608 14.9071L37.0363 8.92377L35.8566 6.87341L18.4283 12.8567L19.608 14.9071Z"
                                     fill="#565151" />
                                 <path
                                     d="M1 8.92377L-1.60031 7.42765L-3.41418 10.5802L0.0258695 11.7612L1 8.92377ZM18.4283 14.9071L17.4542 17.7446L19.7946 18.5481L21.0286 16.4032L18.4283 14.9071ZM19.608 12.8567L22.2083 14.3528L24.0221 11.2003L20.5821 10.0193L19.608 12.8567ZM2.1797 6.87341L3.15382 4.03597L0.813433 3.23249L-0.420607 5.37729L2.1797 6.87341ZM20.4705 30.336V33.336H23.4705V30.336H20.4705ZM20.4705 13.8819H23.4705V10.8819H20.4705V13.8819ZM17.5658 13.8819V10.8819H14.5658V13.8819H17.5658ZM17.5658 30.336H14.5658V33.336H17.5658V30.336ZM19.608 14.9071L17.0077 16.4032L18.2417 18.5481L20.5821 17.7446L19.608 14.9071ZM37.0363 8.92377L38.0104 11.7612L41.4505 10.5802L39.6366 7.42765L37.0363 8.92377ZM35.8566 6.87341L38.4569 5.37729L37.2229 3.23249L34.8825 4.03597L35.8566 6.87341ZM18.4283 12.8567L17.4542 10.0193L14.0142 11.2003L15.828 14.3528L18.4283 12.8567ZM0.0258695 11.7612L17.4542 17.7446L19.4024 12.0697L1.97413 6.08633L0.0258695 11.7612ZM21.0286 16.4032L22.2083 14.3528L17.0077 11.3606L15.828 13.411L21.0286 16.4032ZM20.5821 10.0193L3.15382 4.03597L1.20558 9.71086L18.6339 15.6942L20.5821 10.0193ZM-0.420607 5.37729L-1.60031 7.42765L3.60031 10.4199L4.78001 8.36954L-0.420607 5.37729ZM23.4705 30.336V13.8819H17.4705V30.336H23.4705ZM20.4705 10.8819H17.5658V16.8819H20.4705V10.8819ZM14.5658 13.8819V30.336H20.5658V13.8819H14.5658ZM17.5658 33.336H20.4705V27.336H17.5658V33.336ZM20.5821 17.7446L38.0104 11.7612L36.0622 6.08633L18.6339 12.0697L20.5821 17.7446ZM39.6366 7.42765L38.4569 5.37729L33.2563 8.36954L34.436 10.4199L39.6366 7.42765ZM34.8825 4.03597L17.4542 10.0193L19.4024 15.6942L36.8307 9.71086L34.8825 4.03597ZM15.828 14.3528L17.0077 16.4032L22.2083 13.411L21.0286 11.3606L15.828 14.3528Z"
                                     fill="#565151" mask="url(#path-1-inside-1_2351_2528)" />
                                 <path
                                     d="M1.58984 23.7695V8.48191C1.58984 8.12724 1.86025 7.80583 2.27985 7.66178L18.5462 2.07735C18.8468 1.97422 19.1895 1.97422 19.4901 2.07735L35.7565 7.66178C36.1761 7.80583 36.4465 8.12724 36.4465 8.48191V23.7695C36.4465 24.1242 36.1761 24.4456 35.7565 24.5897L19.4901 30.1741C19.1895 30.2771 18.8468 30.2771 18.5462 30.1741L2.27985 24.5897C1.86025 24.4456 1.58984 24.1242 1.58984 23.7695Z"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                 <path
                                     d="M10.3042 4.90698L27.0425 10.6534C27.4622 10.7975 27.7325 11.1189 27.7325 11.4735V16.8736"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                         </i>
                         <p>
                             Receiving
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="{{ url('receiving/incoming') }}"
                                 class="nav-link {{ request()->segment(2) == 'incoming' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Kedatangan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ url('receiving/bpnb') }}"
                                 class="nav-link {{ request()->segment(2) == 'bpnb' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>BPNP</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ url('receiving/scan') }}"
                                 class="nav-link {{ request()->segment(2) == 'scan' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Scan</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ url('receiving/scan') }}"
                                 class="nav-link {{ request()->segment(2) == 'return' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Return</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <!-- Receiving End-->

                 <!-- Storage -->
                 <li class="nav-item {{ request()->segment(1) == 'storage' ? 'menu-open' : '' }}">
                     <a href="#" class="nav-link">
                         <i class="nav-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                 viewBox="0 0 44 46" fill="none">
                                 <path d="M2 16.2093L21.5182 2L41.0363 16.2093" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M6.3374 43.3361H36.699" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M17.1807 14.9175H25.8554" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M8.50586 35.5855V22.668" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M17.1807 35.5855V22.668" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M25.8555 35.5855V22.668" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M34.5303 35.5855V22.668" stroke="#565151" stroke-width="4"
                                     stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                         </i>
                         <p>
                             Storage
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <!-- Raw Material -->
                         <li class="nav-item">
                             <a href="{{ url('storage/rawmaterial') }}"
                                 class="nav-link {{ request()->segment(2) == 'rawmaterial' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Raw Material</p>
                             </a>
                         </li>
                         <!-- Finished Good -->
                         <li class="nav-item">
                             <a href="{{ url('storage/finishedgood') }}"
                                 class="nav-link {{ request()->segment(2) == 'finishedgood' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Finished Good</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <!-- Storage End -->

                 <!-- Services -->
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon ">
                             <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                 viewBox="0 0 46 38" fill="none">
                                 <path
                                     d="M35.6289 36.336L43.6669 28.6071C43.9033 28.3797 44.0362 28.0713 44.0362 27.7498V17.1365C44.0362 15.4622 42.6246 14.105 40.8834 14.105C39.1423 14.105 37.7307 15.4622 37.7307 17.1365V26.231"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path
                                     d="M35.6288 28.2519L37.4324 26.5176C37.6234 26.3339 37.7306 26.085 37.7306 25.8255C37.7306 25.4546 37.5127 25.1157 37.1678 24.9498L36.2369 24.5023C34.6187 23.7242 32.664 24.0292 31.3846 25.2594L29.5037 27.068C28.7153 27.826 28.2725 28.8541 28.2725 29.9261V36.3359"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path
                                     d="M10.4073 36.336L2.36937 28.6071C2.13286 28.3797 2 28.0713 2 27.7498V17.1365C2 15.4622 3.41152 14.105 5.15272 14.105C6.89393 14.105 8.30545 15.4622 8.30545 17.1365V26.231"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path
                                     d="M10.4075 28.2519L8.60385 26.5176C8.41292 26.3339 8.30566 26.085 8.30566 25.8255C8.30566 25.4546 8.52354 25.1157 8.86845 24.9498L9.79936 24.5023C11.4177 23.7242 13.3723 24.0292 14.6517 25.2594L16.5326 27.068C17.321 27.826 17.7638 28.8541 17.7638 29.9261V36.3359"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <mask id="path-5-inside-1_2281_497" fill="white">
                                     <path
                                         d="M12 5.39816L22.1563 9.19899L22.8437 7.8965L12.6875 4.0957L12 5.39816ZM23.3464 18.9999V8.54773H21.6536V18.9999H23.3464ZM22.8437 9.19899L33 5.39816L32.3125 4.0957L22.1563 7.8965L22.8437 9.19899Z" />
                                 </mask>
                                 <path
                                     d="M12 5.39816L22.1563 9.19899L22.8437 7.8965L12.6875 4.0957L12 5.39816ZM23.3464 18.9999V8.54773H21.6536V18.9999H23.3464ZM22.8437 9.19899L33 5.39816L32.3125 4.0957L22.1563 7.8965L22.8437 9.19899Z"
                                     fill="#565151" />
                                 <path
                                     d="M12 5.39816L10.2313 4.46458L9.1703 6.47465L11.299 7.27129L12 5.39816ZM22.1563 9.19899L21.4553 11.0721L23.1035 11.689L23.925 10.1326L22.1563 9.19899ZM22.8437 7.8965L24.6125 8.83006L25.6734 6.81999L23.5447 6.02337L22.8437 7.8965ZM12.6875 4.0957L13.3885 2.22257L11.7402 1.60575L10.9187 3.16212L12.6875 4.0957ZM23.3464 18.9999V20.9999H25.3464V18.9999H23.3464ZM23.3464 8.54773H25.3464V6.54773H23.3464V8.54773ZM21.6536 8.54773V6.54773H19.6536V8.54773H21.6536ZM21.6536 18.9999H19.6536V20.9999H21.6536V18.9999ZM22.8437 9.19899L21.075 10.1326L21.8965 11.689L23.5447 11.0721L22.8437 9.19899ZM33 5.39816L33.701 7.27129L35.8297 6.47465L34.7687 4.46458L33 5.39816ZM32.3125 4.0957L34.0813 3.16212L33.2598 1.60575L31.6115 2.22257L32.3125 4.0957ZM22.1563 7.8965L21.4553 6.02337L19.3266 6.81999L20.3875 8.83006L22.1563 7.8965ZM11.299 7.27129L21.4553 11.0721L22.8573 7.32586L12.701 3.52503L11.299 7.27129ZM23.925 10.1326L24.6125 8.83006L21.075 6.96294L20.3875 8.26543L23.925 10.1326ZM23.5447 6.02337L13.3885 2.22257L11.9865 5.96883L22.1427 9.76963L23.5447 6.02337ZM10.9187 3.16212L10.2313 4.46458L13.7687 6.33174L14.4562 5.02928L10.9187 3.16212ZM25.3464 18.9999V8.54773H21.3464V18.9999H25.3464ZM23.3464 6.54773H21.6536V10.5477H23.3464V6.54773ZM19.6536 8.54773V18.9999H23.6536V8.54773H19.6536ZM21.6536 20.9999H23.3464V16.9999H21.6536V20.9999ZM23.5447 11.0721L33.701 7.27129L32.299 3.52503L22.1427 7.32586L23.5447 11.0721ZM34.7687 4.46458L34.0813 3.16212L30.5438 5.02928L31.2313 6.33174L34.7687 4.46458ZM31.6115 2.22257L21.4553 6.02337L22.8573 9.76963L33.0135 5.96883L31.6115 2.22257ZM20.3875 8.83006L21.075 10.1326L24.6125 8.26543L23.925 6.96294L20.3875 8.83006Z"
                                     fill="#565151" mask="url(#path-5-inside-1_2281_497)" />
                                 <path
                                     d="M12.3438 14.8287V5.11753C12.3438 4.89223 12.5013 4.68806 12.7458 4.59655L22.225 1.04914C22.4001 0.983621 22.5999 0.983621 22.775 1.04914L32.2542 4.59655C32.4987 4.68806 32.6563 4.89223 32.6563 5.11753V14.8287C32.6563 15.054 32.4987 15.2582 32.2542 15.3497L22.775 18.8971C22.5999 18.9626 22.4001 18.9626 22.225 18.8971L12.7458 15.3497C12.5013 15.2582 12.3438 15.054 12.3438 14.8287Z"
                                     stroke="#565151" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path
                                     d="M17.4219 2.84668L27.1761 6.497C27.4206 6.58851 27.5781 6.79267 27.5781 7.01798V10.4483"
                                     stroke="#565151" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" />
                             </svg>
                         </i>
                         <p>
                             Services
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <!-- Raw Material -->
                         <li class="nav-item">
                             <a href="{{ url('services/transaksigudang') }}"
                                 class="nav-link {{ request()->segment(2) == 'transaksigudang' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Transaksi Gudang</p>
                             </a>
                         </li>
                         <!-- Finished Good -->
                         <li class="nav-item">
                             <a href="{{ url('services/transaksiproduksi') }}"
                                 class="nav-link {{ request()->segment(2) == 'transaksiproduksi' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Transaksi Produksi</p>
                             </a>
                         </li>
                     </ul>
                 </li>
                 <!-- Services End-->

                 <!-- Shipping-->
                 <li class="nav-item ">
                     <a href="#" class="nav-link">
                         <i class="nav-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                 viewBox="0 0 41 27" fill="none">
                                 <path
                                     d="M13.7728 25C15.6305 25 17.1365 23.4158 17.1365 21.4616C17.1365 19.5073 15.6305 17.9231 13.7728 17.9231C11.9151 17.9231 10.4092 19.5073 10.4092 21.4616C10.4092 23.4158 11.9151 25 13.7728 25Z"
                                     stroke="#565151" stroke-width="3" stroke-miterlimit="1.5"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path
                                     d="M30.5907 25C32.4484 25 33.9543 23.4158 33.9543 21.4616C33.9543 19.5073 32.4484 17.9231 30.5907 17.9231C28.733 17.9231 27.2271 19.5073 27.2271 21.4616C27.2271 23.4158 28.733 25 30.5907 25Z"
                                     stroke="#565151" stroke-width="3" stroke-miterlimit="1.5"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M17.2205 21.4615H25.5455V3.06154C25.5455 2.47527 25.0937 2 24.5364 2H2"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round" />
                                 <path
                                     d="M9.82059 21.4615H6.37286C5.81556 21.4615 5.36377 20.9863 5.36377 20.3999V11.7307"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round" />
                                 <path d="M3.68164 7.30774H10.4089" stroke="#565151" stroke-width="3"
                                     stroke-linecap="round" stroke-linejoin="round" />
                                 <path
                                     d="M25.5454 7.30774H34.9806C35.3793 7.30774 35.7408 7.5548 35.9027 7.93815L38.913 15.0633C38.9704 15.1992 39 15.3461 39 15.4945V20.4C39 20.9864 38.5482 21.4616 37.9909 21.4616H34.7954"
                                     stroke="#565151" stroke-width="3" stroke-linecap="round" />
                                 <path d="M25.5454 21.4615H27.2272" stroke="#565151" stroke-width="3"
                                     stroke-linecap="round" />
                             </svg>
                         </i>
                         <p>
                             Shipping

                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <!-- Raw Material -->
                         <li class="nav-item">
                             <a href="{{ url('shipping/createpackinglist') }}"
                                 class="nav-link {{ request()->segment(2) == 'createpackinglist' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Create Packing List</p>
                             </a>
                         </li>
                         <!-- Finished Good -->
                         <li class="nav-item">
                             <a href="{{ url('shipping/deliveryreceipt') }}"
                                 class="nav-link {{ request()->segment(2) == 'deliveryreceipt' ? 'active' : '' }}">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Delivery Receipt</p>
                             </a>
                         </li>
                     </ul>
                     
                 </li>

                 <!-- Cycle Count -->
                 <li class="nav-item">
                     <a href="#" class="nav-link">
                         <i class="nav-icon">
                             <svg width="26" height="27" viewBox="0 0 36 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                     d="M2 27.4545V4.54545C2 3.13964 3.30244 2 4.90909 2H31.0909C32.6976 2 34 3.13964 34 4.54545V27.4545C34 28.8604 32.6976 30 31.0909 30H4.90909C3.30244 30 2 28.8604 2 27.4545Z"
                                     stroke="black" stroke-opacity="0.6" stroke-width="3" />
                                 <path d="M22.3636 9.63672H25.2727H28.1818" stroke="black" stroke-opacity="0.6"
                                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M22.3636 20.4551H25.2727H28.1818" stroke="black" stroke-opacity="0.6"
                                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                 <path d="M22.3636 24.2725H25.2727H28.1818" stroke="black" stroke-opacity="0.6"
                                     stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                 <path
                                     d="M7.81818 9.63627H10.7273M10.7273 9.63627H13.6364M10.7273 9.63627V7.09082M10.7273 9.63627V12.1817"
                                     stroke="black" stroke-opacity="0.6" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                                 <path
                                     d="M8.67065 24.1633L10.7277 22.3634M10.7277 22.3634L12.7847 20.5635M10.7277 22.3634L8.67065 20.5635M10.7277 22.3634L12.7847 24.1633"
                                     stroke="black" stroke-opacity="0.6" stroke-width="3" stroke-linecap="round"
                                     stroke-linejoin="round" />
                             </svg>
                         </i>
                         <p>
                             Cycle Count
                             <i class="right fas fa-angle-left"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <!-- Raw Material -->
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Raw Material</p>
                                 <i class="right fas fa-angle-left"></i>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="./raw-material-put-away.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Create Cycle Count</p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="./raw-material-rack-monitoring.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Generate & Release</p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="./raw-material-put-away.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p> Pending Review</p>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                         <!-- Finished Good -->
                         <li class="nav-item">
                             <a href="#" class="nav-link">
                                 <i class="far fa-circle nav-icon"></i>
                                 <p>Finished Good</p>
                                 <i class="right fas fa-angle-left"></i>
                             </a>
                             <ul class="nav nav-treeview">
                                 <li class="nav-item">
                                     <a href="./raw-material-put-away.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Create Cycle Count y</p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="./raw-material-rack-monitoring.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Generate and Release Cycle Count</p>
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a href="./raw-material-put-away.html" class="nav-link">
                                         <i class="far fa-circle nav-icon"></i>
                                         <p>Cycle Counting Pending Review</p>
                                     </a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 <!-- Storage End -->

                 <!-- Logout-->
                 <li class="nav-item ">
                     <a href="{{ url('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                         class="nav-link">
                         <i class="nav-icon">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24">
                                 <path fill="currentColor"
                                     d="m16.56 5.44l-1.45 1.45A5.969 5.969 0 0 1 18 12a6 6 0 0 1-6 6a6 6 0 0 1-6-6c0-2.17 1.16-4.06 2.88-5.12L7.44 5.44A7.961 7.961 0 0 0 4 12a8 8 0 0 0 8 8a8 8 0 0 0 8-8c0-2.72-1.36-5.12-3.44-6.56M13 3h-2v10h2" />
                             </svg>
                         </i>
                         <p>
                             Logout
                         </p>
                     </a>
                     <form id="logout-form" action="/logout" method="POST" style="display: none;">
                         @csrf
                     </form>
                 </li>
             </ul>
         </nav>
     </div>
 </aside>
