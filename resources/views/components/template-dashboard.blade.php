<!DOCTYPE html>
<html lang="{{ config('language') }}">
<head>
<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Sports TV Rights">
<meta name="theme-color" content="#212529">

<meta name="htmx-config" content='{"timeout":"600000"}'>

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/logo-index.png') }}">

<link rel="stylesheet" href="{{ node('flowbite/dist/flowbite.css') }}">
<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">
<link rel="stylesheet" href="{{ node('sweetalert2/dist/sweetalert2.css') }}">

<script src="https://cdn.tailwindcss.com"></script>

<style>
    .wg_modal {
        z-index: 100 !important;
    }

    .Opta .Opta-H2, .Opta h2 {
        background-color: #132141 !important;
    }

    .match-btn, .match-btn:hover, .match-btn:focus {
        background-color: #132141 !important;
        border-color: #132141 !important;
    }

    body {
        background: url('{{ asset('img/fondo.jpg')  }}');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .bg-blue-tigo, .btn-blue-tigo {
        background-color: #071029 !important;
    }

    .bg-blue-tigo-1 {
        background-color: #132141;
    }

    select, input {
        color: black !important;
    }

    th, td {
        color: black !important;
    }

    h1, h2 {
        color: white;
    }
</style>

</head>

<body x-data="app()" class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-blue-tigo fixed w-full z-10 top-0 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">
            <div class="w-1/2 pl-2 md:pl-0">
                <a class="text-white text-base xl:text-xl no-underline hover:no-underline font-bold" href="/dashboard">
                    <img class="w-1/3" src="{{ asset('img/logo-index.png') }}" alt="Logo">
                </a>
            </div>

            <div class="w-1/2 pr-0">
                <div class="flex relative inline-block float-right">
                    <div class="relative text-sm">
                        <button x-on:click="showUserMenu = !showUserMenu" class="bg-blue-tigo flex text-white items-center focus:outline-none mr-3">
                            <img class="w-8 h-8 rounded-full mr-4" src="{{ auth()->photo }}" alt="Avatar of User"> 
                            <span class="hidden md:inline-block">{{ auth()->name }}</span>

                            <svg class="pl-2 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                <g>
                                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z">
                                </g>
                            </svg>
                        </button>

                        <div x-show="showUserMenu" class="bg-blue-tigo rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30">
                            <ul class="list-reset">
                                <li>
                                    <a href="{{ '/dashboard/users/edit/' . auth()->id }}" class="px-4 py-2 block text-white hover:bg-gray-400 no-underline hover:no-underline">{{ lang('dashboard.profile') }}</a>
                                </li>

                                <li>
                                    <a href="/logout" class="px-4 py-2 block text-white hover:bg-gray-400 no-underline hover:no-underline">{{ lang('dashboard.logout') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="block lg:hidden pr-4">
                        <button x-on:click="showMainMenu = !showMainMenu" class="bg-blue-tigo flex items-center px-3 py-2 border rounded text-white border-gray-600 hover:text-white hover:border-teal-500 appearance-none focus:outline-none">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>{{ lang('dashboard.menu') }}</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z">
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="showMainMenu" class="bg-blue-tigo mainMenu w-full flex-grow lg:flex lg:items-center lg:w-auto lg:block mt-2 lg:mt-0 bg-white z-20">
                <ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
                    <li class="mr-2 my-2 md:my-0">
                        <a href="/dashboard" class="{{ ($active == 'home') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-home fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ lang('dashboard.home') }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/bolivia/liga" class="{{ ($active == 'bolivia.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Bolivia' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/bolivia/copa" class="{{ ($active == 'bolivia.copa') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Copa Bolivia' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/españa/liga" class="{{ ($active == 'españa.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga España' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/españa/copa" class="{{ ($active == 'españa.copa') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Copa del Rey' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/inglaterra/liga" class="{{ ($active == 'inglaterra.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Premier League' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/europa/champions" class="{{ ($active == 'europa.champions') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Champions League' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/europa/europa" class="{{ ($active == 'europa.europa') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Europa League' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/italia/liga" class="{{ ($active == 'italia.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Italia' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/argentina/liga" class="{{ ($active == 'argentina.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Argentina' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/francia/liga" class="{{ ($active == 'francia.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Francia' }}</span>
                        </a>
                    </li>

                    <li class="mr-2 my-2 md:my-0">
                        <a href="/alemania/liga" class="{{ ($active == 'alemania.liga') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                            <i class="fas fa-futbol fa-fw mr-2 text-silver-600"></i> <span class="pb-1 md:pb-0 text-sm">{{ 'Liga Alemania' }}</span>
                        </a>
                    </li>

                    @if(auth()->role == 'producer' || auth()->role == 'admin')
                        <li class="mr-2 my-2 md:my-0">
                            <a href="/export" class="{{ ($active == 'export') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                                <i class="fas fa-download fa-fw mr-2"></i> <span class="pb-1 md:pb-0 text-sm">Exportar datos</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->role == 'admin')
                        <li class="mr-3 my-2 md:my-0">
                            <a href="/dashboard/users" class="{{ ($active == 'users') ? 'block py-1 md:py-3 pl-1 align-middle text-[#FFC200] no-underline hover:text-[#FFC200] border-b-2 border-[#FFC200] hover:border-[#FFC200]' : 'block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-[#FFC200] border-b-2 border-white hover:border-[#FFC200]' }}">
                                <i class="fas fa-users fa-fw mr-3"></i> <span class="pb-1 md:pb-0 text-sm">{{ lang('dashboard.users') }}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container w-full mx-auto pt-20">
        <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
            <div class="flex flex-wrap">
                {{ $slot }}
            </div>
        </div>
    </div>

    <footer class="text-white text-center mb-5">
        <center>Powered by <img width="150px" src="https://sportstvrights.com/wp-content/uploads/2022/06/SPORTSTVRIGHTS-CON-BOCETO-BLANCO.png" alt=""></center>
    </footer>

    <input type="hidden" id="confirm_delete_text" value="{{ lang('users.confirm_delete_text') }}">
    <input type="hidden" id="confirm_delete_accept" value="{{ lang('users.confirm_delete_accept') }}">
    <input type="hidden" id="confirm_delete_cancel" value="{{ lang('users.confirm_delete_cancel') }}">

    <script src="{{ node('flowbite/dist/flowbite.js') }}" defer></script>
    <script src="{{ node('alpinejs/dist/cdn.js') }}" defer></script>
    <script src="{{ node('sweetalert2/dist/sweetalert2.js') }}"></script>
    <script src="{{ node('htmx.org/dist/htmx.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script type="module" src="https://widgets.api-sports.io/2.0.3/widgets.js"></script>
</body>
</html>