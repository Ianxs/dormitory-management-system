<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Tenant</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.2.1/dist/datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex bg-gray-900"
    style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
    <notification
        :message="notificationMessage"
        :type="notificationType"
        v-if="showNotification"
        @close="showNotification = false"
    ></notification>

    <div id="app" class="flex justify-between w-full">
        <!-- Sidebar -->
        <aside class="w-72 bg-gray-800 min-h-screen p-4 space-y-6 sticky top-0 h-screen overflow-y-auto">
            <h1 class="text-2xl text-[#ffc329] font-bold">DORMNEST</h1>
            <nav class="space-y-8 flex flex-col text-white text-xl">
                <ul class="mt-6 space-y-2">
                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.dashboard') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    <span class="whitespace-nowrap">Dashboard</span>
                                </div>
                            </span>
                        </a>
                    </li>

                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.maintenance-requests') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                        </path>
                                    </svg>
                                    <span>Maintenance Request</span>
                                </div>
                            </span>
                        </a>
                    </li>

                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.payment-history') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    <span class="whitespace-nowrap">Payment</span>
                                </div>
                            </span>
                        </a>
                    </li>

                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.manage-dorm') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                    <span class="whitespace-nowrap">Manage Dormitory</span>
                                </div>
                            </span>
                        </a>
                    </li>

                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.add-tenant') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-[#ffc329] rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-gray-900 transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                    <span class="whitespace-nowrap">+ Add Tenants</span>
                                </div>
                            </span>
                        </a>
                    </li>

                    <li class="relative px-3 py-3">
                        <a href="{{ route('admin.archive') }}"
                            class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                            <span
                                class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                            <span
                                class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M20 7V4H4v3" />
                                        <path d="M4 7l1.447 12.158A2 2 0 007.43 21h9.14a2 2 0 001.982-1.842L20 7" />
                                        <path d="M9 12h6" />
                                    </svg>
                                    <span class="whitespace-nowrap">Archive</span>
                                </div>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex flex-col p-6 w-full">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-white">{{ $adminTitle }}</h2>
                <div class="flex items-center space-x-4">

                    <div class="flex items-center space-x-4 text-[#ffc329]">
                        <div class="grid auto-cols-max grid-flow-col gap-2 text-center">
                            <div class="bg-gray-800 rounded-xl flex flex-col px-3 py-1">
                                <span class="countdown font-mono text-2xl">
                                    <span :style="`--value:${time.hours}`">@{{ time.hours }}</span>
                                </span>
                                <span class="text-xs text-gray-300">Hours</span>
                            </div>
                            <div class="bg-gray-800 rounded-xl flex flex-col px-3 py-1">
                                <span class="countdown font-mono text-2xl">
                                    <span :style="`--value:${time.minutes}`">@{{ time.minutes }}</span>
                                </span>
                                <span class="text-xs text-gray-300">Min</span>
                            </div>
                            <div class="bg-gray-800 rounded-xl flex flex-col px-3 py-1">
                                <span class="countdown font-mono text-2xl">
                                    <span :style="`--value:${time.seconds}`">@{{ time.seconds }}</span>
                                </span>
                                <span class="text-xs text-gray-300">Sec</span>
                            </div>
                        </div>

                        <div class="text-sm text-[#ffc329]">
                            @{{ formattedDate }}
                        </div>
                    </div>



                    <div class="relative inline-block">
                        <!-- Profile dropdown -->
                        <button @click="toggleDropdown"
                            class="relative z-10 block p-2 border-transparent rounded-md focus:outline-none">
                            <svg class="w-8 h-8 text-[#ffc329]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <transition name="fade">
                            <div v-if="isOpen"
                                class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl dark:bg-gray-800">
                                <button @click="toggleProfileModal"
                                    class="block w-full text-left px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                    Edit admin account
                                </button>
                                <a href="{{ url('/') }}"
                                    class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                    Log Out
                                </a>
                            </div>
                        </transition>

                        <!-- Profile Modal -->
                        <div v-if="isProfileModalOpen"
                            class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog"
                            aria-modal="true" aria-labelledby="modalTitle">
                            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900">
                                <div class="flex items-start justify-between">
                                    <h2 id="modalTitle"
                                        class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">Edit Admin Account</h2>
                                    <button type="button" @click="toggleProfileModal"
                                        class="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                        aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <form @submit.prevent="handleDone" class="mt-4 space-y-6">

                                    <div class="flex flex-col lg:flex-row gap-2 justify-center w-full">
                                        <div class="w-full mb-4 mt-6">
                                            <label class="mb-2 dark:text-gray-300">Username</label>
                                            <input type="text"
                                                class="mt-2 p-4 w-48 h-8 border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                                placeholder="Enter username">
                                        </div>
                                        <div class="w-full mb-4 lg:mt-6">
                                            <label class="dark:text-gray-300">Current Password</label>
                                            <input type="password"
                                                class="mt-2 p-4 w-48 h-8 border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                                placeholder="Current password">
                                        </div>
                                    </div>

                                    <div class="flex flex-col lg:flex-row gap-2 justify-center w-full">
                                        <div class="w-full">
                                            <h3 class="dark:text-gray-300 mb-2">New Password</h3>
                                            <input type="password"
                                                class="mt-2 p-4 w-48 h-8 border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                                placeholder="New password">
                                        </div>
                                        <div class="w-full">
                                            <h3 class="dark:text-gray-300 mb-2">Confirm Password</h3>
                                            <input type="password"
                                                class="mt-2 p-4 w-48 h-8 border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                                placeholder="Confirm password">
                                        </div>
                                    </div>

                                    <div class="flex flex-row space-x-16 items-center justify-center mt-12">
                                        <button type="button" @click="toggleProfileModal"
                                            class="w-48 h-8 rounded bg-[#ffc329] mt-4 text-gray-800 text-lg font-semibold transition-colors duration-300 hover:bg-gray-700 hover:text-[#ffc329]">Cancel</button>
                                        <button type="submit"
                                            class="w-48 h-8 rounded bg-[#ffc329] mt-4 text-gray-800 text-lg font-semibold transition-colors duration-300 hover:bg-gray-700 hover:text-[#ffc329]">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <section class="mt-4">

                <section class="container px-4 mx-auto">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-x-3">
                                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Tenants</h2>

                                <span
                                    class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-[#ffc329]">{{ count($tenants) }}
                                    Tenants</span>
                            </div>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">List of Dormnest Tenants</p>
                        </div>

                        <div class="flex items-center mt-4 gap-x-3">
{{--                            <form action="{{ route('admin.clear-tenant-data') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all tenant data? This action cannot be undone.');">--}}
{{--                                @csrf--}}
{{--                                <button type="submit"--}}
{{--                                    class="flex items-center justify-center px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-red-600 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-red-700">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />--}}
{{--                                    </svg>--}}
{{--                                    <span>Clear Tenant Data</span>--}}
{{--                                </button>--}}
{{--                            </form>--}}
                            <button @click="toggledAddTenant"
                                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-gray-900 transition-colors duration-200 bg-[#ffc329] rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-gray-800 dark:hover:text-[#ffc329] dark:bg-[#ffc329]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <span>Add Tenant</span>
                            </button>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="relative flex justify-center">


                        <div v-if="isAddTenant" x-transition:enter="transition duration-300 ease-out"
                            x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                            x-transition:leave="transition duration-150 ease-in"
                            x-transition:leave-start="translate-y-0 opacity-100 sm  :scale-100"
                            x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                            class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                            aria-modal="true">
                            <div
                                class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <span class="hidden sm:inline-block sm:h-screen sm:align-middle"
                                    aria-hidden="true">&#8203;</span>

                                <div
                                    class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">
                                    <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize dark:text-white"
                                        id="modal-title">
                                        Add Tenant Information
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        Add a new tenant to the dormitory system. Fill in all required information below.
                                    </p>

                                    <form class="mt-4" id="tenantForm" @submit.prevent="showConfirmation">
                                        @csrf
                                        <label for="tenant_name" class="text-sm text-gray-700 dark:text-gray-200">
                                            Basic Information
                                        </label>

                                        @if(session('success'))
                                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        @if ($errors->any())
                                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif

                                        <label class="block mt-2 text-white" for="tenant_name">
                                            Name
                                            <input type="text" name="tenant_name" id="tenant_name" placeholder="Full Name" required
                                                class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />
                                        </label>

                                        <label class="block mt-2 text-white" for="tenant_contact">
                                            Contact
                                            <input type="text" name="tenant_contact" id="tenant_contact" placeholder="XXXX-XXX-XXX" required
                                                class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300" />
                                        </label>

                                        <label class="block mt-3 text-white" for="total_occupants">
                                            Total Occupants
                                            <select name="total_occupants" id="total_occupants" required
                                                class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white rounded-md focus:border-[#ffc329] focus:outline-none focus:ring focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </label>


                                        <label class="block mt-2 text-white" for="room_number">
                                            Room Number
                                            <select
                                                id="room_number"
                                                name="room_number"
                                                v-model="selectedRoom"
                                                required
                                                class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md
                                                       focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40
                                                       dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">
                                                <option value="" disabled>Select a room</option>
                                                <option
                                                    v-for="room in availableRooms"
                                                    :key="room.room_number"
                                                    :value="room.room_number"
                                                >
                                                    Room @{{ room.room_number }}
                                                </option>
                                            </select>
                                        </label>


{{--                                        <label class="block mt-2 text-white" for="room_number">--}}
{{--                                            Room Number--}}
{{--                                            <select id="room_number" name="room_number" v-model="selectedRoom" required--}}
{{--                                                    class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md--}}
{{--                                                       focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40--}}
{{--                                                       dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-blue-300">--}}
{{--                                                <option value="" disabled>Select a room</option>--}}
{{--                                                <option v-for="room in availableRooms" :key="room.room_number" :value="room.room_number">--}}
{{--                                                    Room @{{ room.room_number }}--}}
{{--                                                </option>--}}
{{--                                            </select>--}}
{{--                                        </label>--}}

                                        <label class="block mt-3 text-white" for="subscriptions">
                                            Subscriptions
                                            <select name="subscriptions" id="subscriptions" required
                                                class="mt-2 block w-full px-4 py-3 text-sm text-gray-700 bg-white rounded-md focus:border-[#ffc329] focus:outline-none focus:ring focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300">
                                                <option value="Student Plan">Student Plan</option>
                                                <option value="Regular Plan">Regular Plan</option>
                                                <option value="Premium Plan">Premium Plan</option>
                                            </select>
                                        </label>

                                        <div class="flex items-center mt-6">
                                            <div class="relative w-full">
                                                <label class="block mb-2 text-white" for="start_date">
                                                    Start Date
                                                </label>
                                                <input id="start_date" name="start_date" type="date" required
                                                       v-model="formData.start_date"
                                                       :min="minStartDate"
                                                       @change="onStartDateChange"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                            </div>

                                            <div class="relative w-full ml-4">
                                                <label class="block mb-2 text-white" for="end_date">
                                                    End Date
                                                </label>
                                                <input id="end_date" name="end_date" type="date" required
                                                       v-model="formData.end_date"
                                                       :min="formData.start_date"
                                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                            </div>

                                        </div>

                                        <div class="mt-6 sm:flex sm:items-center sm:-mx-2">
                                            <button type="button" @click="isAddTenant = false"
                                                class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                                                Cancel
                                            </button>

                                            <button type="submit"
                                                class="w-full px-4 py-2 mt-3 text-sm font-medium tracking-wide text-gray-900 capitalize transition-colors duration-300 transform bg-[#ffc329] rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-gray-900 hover:text-[#ffc329] focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                                                Add Tenant
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- confirmation modal -->

                    <div v-if="confirmation" class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                            @click="confirmation = false"></div>

                        <div class="flex min-h-full items-center justify-center p-4">
                            <div
                                class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                                <button @click="confirmation = false"
                                    class="absolute right-2 top-2 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Receipt Content -->
                                <div class="bg-gray-800 text-gray-300 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="w-full text-center">

                                            <!-- Business Info -->
                                            <div class="mt-3 text-center sm:mt-5">
                                                <h3 class="text-lg font-medium leading-6 text-[#ffc329]">DormNest</h3>
                                                <p class="mt-1 text-sm text-gray-500">123 Business Street, City</p>
                                            </div>

                                            <!-- Order Details -->
                                            <div class="mt-4 border-t border-gray-200 pt-4 text-sm">
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Name:</span>
                                                    <span>@{{ formData.tenant_name }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Contact:</span>
                                                    <span>@{{ formData.tenant_contact }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Room Number:</span>
                                                    <span>@{{ formData.room_number }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Subscription Type:</span>
                                                    <span>@{{ formData.subscriptions }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Total Occupants:</span>
                                                    <span>@{{ formData.total_occupants }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Tenant ID:</span>
                                                    <span>@{{ formData.tenant_id || 'Generating...' }}</span>
                                                </div>
                                                <div class="flex justify-between py-1">
                                                    <span class="text-[#ffc329]">Password:</span>
                                                    <span>@{{ formData.password }}</span>
                                                </div>
                                            </div>

                                            <!-- Order Items -->
                                            <div class="mt-4 border-t border-gray-200 pt-4">
                                                <table class="w-full text-left">
                                                    <thead>
                                                        <tr class="border-b border-gray-200">
                                                            <th class="w-20 pb-2 font-medium">Start Date</th>
                                                            <th class="w-20 pb-2 font-medium">End Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="border-b border-gray-100">
                                                            <td class="py-2">@{{ formData.start_date }}</td>
                                                            <td class="py-2">@{{ formData.end_date }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </div>

                                            <!-- Contact Info -->
                                            <div class="mt-6 flex flex-col items-center gap-2 text-sm text-gray-500">
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M21.3 12.23h-3.48c-.98 0-1.85.54-2.29 1.42l-.84 1.66c-.2.4-.6.65-1.04.65h-3.28c-.31 0-.75-.07-1.04-.65l-.84-1.65a2.567 2.567 0 0 0-2.29-1.42H2.7c-.39 0-.7.31-.7.7v3.26C2 19.83 4.18 22 7.82 22h8.38c3.43 0 5.54-1.88 5.8-5.22v-3.85c0-.38-.31-.7-.7-.7ZM12.75 2c0-.41-.34-.75-.75-.75s-.75.34-.75.75v2h1.5V2Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M22 9.81v1.04a2.06 2.06 0 0 0-.7-.12h-3.48c-1.55 0-2.94.86-3.63 2.24l-.75 1.48h-2.86l-.75-1.47a4.026 4.026 0 0 0-3.63-2.25H2.7c-.24 0-.48.04-.7.12V9.81C2 6.17 4.17 4 7.81 4h3.44v3.19l-.72-.72a.754.754 0 0 0-1.06 0c-.29.29-.29.77 0 1.06l2 2c.01.01.02.01.02.02a.753.753 0 0 0 .51.2c.1 0 .19-.02.28-.06.09-.03.18-.09.25-.16l2-2c.29-.29.29-.77 0-1.06a.754.754 0 0 0-1.06 0l-.72.72V4h3.44C19.83 4 22 6.17 22 9.81Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    info@example.com
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path fill="currentColor"
                                                            d="M11.05 14.95L9.2 16.8c-.39.39-1.01.39-1.41.01-.11-.11-.22-.21-.33-.32a28.414 28.414 0 01-2.79-3.27c-.82-1.14-1.48-2.28-1.96-3.41C2.24 8.67 2 7.58 2 6.54c0-.68.12-1.33.36-1.93.24-.61.62-1.17 1.15-1.67C4.15 2.31 4.85 2 5.59 2c.28 0 .56.06.81.18.26.12.49.3.67.56l2.32 3.27c.18.25.31.48.4.7.09.21.14.42.14.61 0 .24-.07.48-.21.71-.13.23-.32.47-.56.71l-.76.79c-.11.11-.16.24-.16.4 0 .08.01.15.03.23.03.08.06.14.08.2.18.33.49.76.93 1.28.45.52.93 1.05 1.45 1.58.1.1.21.2.31.3.4.39.41 1.03.01 1.43zM21.97 18.33a2.54 2.54 0 01-.25 1.09c-.17.36-.39.7-.68 1.02-.49.54-1.03.93-1.64 1.18-.01 0-.02.01-.03.01-.59.24-1.23.37-1.92.37-1.02 0-2.11-.24-3.26-.73s-2.3-1.15-3.44-1.98c-.39-.29-.78-.58-1.15-.89l3.27-3.27c.28.21.53.37.74.48.05.02.11.05.18.08.08.03.16.04.25.04.17 0 .3-.06.41-.17l.76-.75c.25-.25.49-.44.72-.56.23-.14.46-.21.71-.21.19 0 .39.04.61.13.22.09.45.22.7.39l3.31 2.35c.26.18.44.39.55.64.1.25.16.5.16.78z">
                                                        </path>
                                                    </svg>
                                                    +1 (234) 567-8900
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Actions -->
                                <div class="bg-gray-800 px-4 py-3 flex justify-center space-x-4">
                                    <button type="button" @click="confirmation = false"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-gray-700 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="button" @click="submitForm"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-[#ffc329] px-4 py-2 text-base font-medium text-gray-900 shadow-sm hover:bg-gray-900 hover:text-[#ffc329] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Archive Confirmation Modal -->
                    <div v-if="archiveConfirmation" class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                            @click="archiveConfirmation = false"></div>

                        <div class="flex min-h-full items-center justify-center p-4">
                            <div
                                class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                                <button @click="archiveConfirmation = false"
                                    class="absolute right-2 top-2 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Archive Confirmation Content -->
                                <div class="bg-gray-800 text-gray-300 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="w-full text-center">
                                            <div class="mt-3 text-center sm:mt-5">
                                                <h3 class="text-lg font-medium leading-6 text-[#ffc329]">Archive Tenant</h3>
                                                <p class="mt-2 text-sm text-gray-400">
                                                    Are you sure you want to archive this tenant? This action will remove the tenant from the active list and move them to the archive.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Actions -->
                                <div class="bg-gray-800 px-4 py-3 flex justify-center space-x-4">
                                    <button type="button" @click="archiveConfirmation = false"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-gray-700 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="button" @click="archiveTenant"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Archive
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Extend Modal -->
                    <div v-if="extendModal" class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
                            @click="extendModal = false"></div>

                        <div class="flex min-h-full items-center justify-center p-4">
                            <div
                                class="relative transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
                                <button @click="extendModal = false"
                                    class="absolute right-2 top-2 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <!-- Extend Content -->
                                <div class="bg-gray-800 text-gray-300 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="w-full text-center">
                                            <div class="mt-3 text-center sm:mt-5">
                                                <h3 class="text-lg font-medium leading-6 text-[#ffc329]">Extend Lease</h3>
                                                <p class="mt-2 text-sm text-gray-400">
                                                    Current end date: @{{ currentEndDate }}
                                                </p>
                                            </div>

                                            <form id="extendForm" class="mt-4" @submit.prevent="extendTenant">
                                                <div class="relative w-full">
                                                    <label class="block mb-2 text-white" for="new_end_date">
                                                        New End Date
                                                    </label>
                                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none mt-8">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                        </svg>
                                                    </div>
                                                    <input v-model="newEndDate" id="new_end_date" name="new_end_date" type="date" required
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Actions -->
                                <div class="bg-gray-800 px-4 py-3 flex justify-center space-x-4">
                                    <button type="button" @click="extendModal = false"
                                        class="inline-flex justify-center rounded-md border border-gray-300 bg-gray-700 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                    <button type="button" @click="extendTenant"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-[#ffc329] px-4 py-2 text-base font-medium text-gray-900 shadow-sm hover:bg-gray-900 hover:text-[#ffc329] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-sm">
                                        Extend
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="mt-6 md:flex md:items-center md:justify-between">
                        <div
                            class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                            <button @click="filterTenants('all')"
                                :class="{'bg-gray-100 dark:bg-gray-800': currentFilter === 'all'}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                View all
                            </button>
                            <button @click="filterTenants('Student Plan')"
                                :class="{'bg-gray-100 dark:bg-gray-800': currentFilter === 'Student Plan'}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                Student Plan
                            </button>
                            <button @click="filterTenants('Regular Plan')"
                                :class="{'bg-gray-100 dark:bg-gray-800': currentFilter === 'Regular Plan'}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                Regular Plan
                            </button>
                            <button @click="filterTenants('Premium Plan')"
                                :class="{'bg-gray-100 dark:bg-gray-800': currentFilter === 'Premium Plan'}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                Premium Plan
                            </button>
                        </div>

                        <div class="relative flex items-center mt-4 md:mt-0">
                            <span class="absolute">
                                <a href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </a>

                            </span>

                            <input type="text" v-model="searchQuery" @input="filterTenants(currentFilter)" placeholder="Search Tenant ID or Name"
                                class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        </div>
                    </div>

                    <section v-if="isEmpty">
                        <div class="flex items-center mt-6 text-center border rounded-lg h-96 dark:border-gray-700">
                            <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                                <div class="p-3 mx-auto text-[#ffc329] bg-blue-100 rounded-full dark:bg-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <h1 class="mt-3 text-lg text-gray-800 dark:text-white">No Tenant found</h1>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">Your search "@{{ searchQuery }}" did not match
                                    any tenant. Please try again or add a new tenant.</p>
                                <div class="flex items-center mt-4 sm:mx-auto gap-x-3">
                                    <button @click="clearSearch"
                                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                        Clear Search
                                    </button>

                                    <button @click="toggledAddTenant"
                                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-gray-900 transition-colors duration-200 bg-[#ffc329] rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-gray-800 dark:bg-[#ffc329] dark:hover:text-[#ffc329]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>

                                        <span>Add Tenant</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section v-if="ShowTenants" class="mt-6">

                        <section class="container px-4 mx-auto">
                            <div class="flex flex-col">
                                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-4">
                                        <div
                                            class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-50 dark:bg-gray-800">
                                                    <tr>
                                                        <th scope="col"
                                                            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            <div class="flex items-center gap-x-3">

                                                                <button class="flex items-center gap-x-2">
                                                                    <span>Tenant ID</span>
                                                                </button>
                                                            </div>
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Lease-end
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Room Number
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Status
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Tenant
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Total occupants
                                                        </th>

                                                        <th scope="col"
                                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                            Subscription
                                                        </th>

                                                        <th scope="col" colspan="2" class="relative py-3.5 px-4 text-gray-500 dark:text-gray-400">
                                                            Actions
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                                    <tr v-for="tenant in filteredTenants" :key="tenant.id">
                                                        <td
                                                            class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                                            <div class="inline-flex items-center gap-x-3">
                                                                <input type="checkbox"
                                                                    class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">

                                                                <span>@{{ tenant.tenant_id }}</span>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            @{{ tenant.lease_end }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-center text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            @{{ tenant.room_number }}
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                                            <div
                                                                class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60 dark:bg-gray-800">
                                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M10 3L4.5 8.5L2 6" stroke="currentColor"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>

                                                                <h2 class="text-sm font-normal">@{{ tenant.status }}</h2>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            <div class="flex items-center gap-x-2">
                                                                <div>
                                                                    <h2
                                                                        class="text-sm font-medium text-gray-800 dark:text-white ">
                                                                        @{{ tenant.tenant_name }}</h2>
                                                                    <p
                                                                        class="text-xs font-normal text-gray-600 dark:text-gray-400">
                                                                        @{{ tenant.tenant_contact }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-center text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            <span v-if="roomOccupancy && roomOccupancy[tenant.room_number]">
                                                                @{{ roomOccupancy[tenant.room_number].current }}/@{{ roomOccupancy[tenant.room_number].capacity }}
                                                            </span>
                                                            <span v-else>
                                                                @{{ tenant.total_occupants }}/6
                                                            </span>
                                                        </td>
                                                        <td
                                                            class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                                            @{{ tenant.subscriptions }}
                                                        </td>

                                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                            <div class="flex items-center gap-x-6">
                                                                <div class="flex items-center gap-x-3">
                                                                     <button @click="showExtendModal(tenant.id, tenant.lease_end)"
                                                                            class="text-blue-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none">
                                                                        Extend
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-center">
                                                            <button type="button"
                                                                    class="text-red-500 hover:text-red-700 transition-colors duration-200 focus:outline-none"
                                                                    @click="showDeleteConfirmation(tenant.id)">
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- Delete Confirmation Modal -->
                                            <div v-if="isDeleteConfirmationOpen"
                                                 class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                                <div class="bg-white p-6 rounded shadow w-96">
                                                    <h2 class="text-lg font-semibold text-red-600 mb-4">Confirm Deletion</h2>

                                                    <textarea v-model="deleteReason"
                                                              placeholder="Reason for deletion"
                                                              class="w-full border border-gray-300 rounded p-2 text-sm mb-4"
                                                              required></textarea>

                                                    <div class="flex justify-end space-x-2">
                                                        <button @click="isDeleteConfirmationOpen = false"
                                                                class="bg-gray-300 hover:bg-gray-400 px-3 py-1 text-sm rounded">
                                                            Cancel
                                                        </button>
                                                        <button @click="confirmDeletion"
                                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded">
                                                            Confirm Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </section>
                </section>
            </section>
        </main>
    </div>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                    // UI States
                    isOpen: false,
                    isNotificationModalOpen: false,
                    isProfileModalOpen: false,
                    isStudentInfoOpen: false,
                    isRegularInfoOpen: false,
                    isVIPInfoOpen: false,
                    isAddTenant: false,
                    isEmpty: {{ $tenants->isEmpty() ? 'true' : 'false' }},
                    confirmation: false,
                    archiveConfirmation: false,
                    extendModal: false,
                    ShowTenants: {{ $tenants->isEmpty() ? 'false' : 'true' }},
                    adminTitle: 'Add Tenants',
                    tenants: @json($tenants),
                    filteredTenants: @json($tenants),
                    roomOccupancy: @json($roomOccupancy ?? []),
                    currentFilter: 'all',
                    isDeleteConfirmationOpen: false,
                    deleteReason: '',
                    showNotification: false,
                    notificationMessage: '',
                    notificationType: 'success',
                    selectedRoom: '',
                    availableRooms: [],

                    formData: {
                        tenant_name: '',
                        tenant_contact: '',
                        total_occupants: '',
                        room_number: '',
                        subscriptions: '',
                        start_date: '',
                        end_date: '',
                        tenant_id: 'Will be generated',
                        password: 'password123',
                    },
                    selectedTenantId: null,
                    currentEndDate: '',
                    newEndDate: '',
                    searchQuery: '',
                    minStartDate: '',
                    // roomsWithNoTenants: [],


                    // Clock Data
                    time: {
                        hours: '00',
                        minutes: '00',
                        seconds: '00'
                    },
                    formattedDate: '',

                    // Navigation Items
                    navItems: [
                        {
                            section: 'adminDashboard',
                            title: 'Dashboard',
                            icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'
                        },
                        {
                            section: 'maintenanceReq',
                            title: 'Maintenance Request',
                            icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>'
                        },
                        {
                            section: 'history',
                            title: 'Payment History',
                            icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>'
                        },
                        {
                            section: 'editDormnest',
                            title: 'Edit DormNest',
                            icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>'
                        }
                    ],
                };
            },
            methods: {
                onStartDateChange() {
                    // If end_date is before start_date, reset it
                    if (this.formData.end_date && this.formData.end_date < this.formData.start_date) {
                        this.formData.end_date = '';
                    }
                },
                toggleDropdown() {
                    this.isOpen = !this.isOpen;
                },
                toggledAddTenant() {
                    this.isAddTenant = !this.isAddTenant;
                },
                toggledReceipt() {
                    this.isEmpty = !this.isEmpty;
                    this.ShowTenants = !this.isEmpty;
                    this.isAddTenant = !this.isAddTenant;
                    this.confirmation = !this.confirmation;
                },
                showConfirmation(event) {
                    // Get form data
                    const form = document.getElementById('tenantForm');
                    const formData = new FormData(form);

                    // Update formData object
                    this.formData.tenant_name = formData.get('tenant_name');
                    this.formData.tenant_contact = formData.get('tenant_contact');
                    this.formData.total_occupants = formData.get('total_occupants');
                    this.formData.room_number = formData.get('room_number');
                    this.formData.subscriptions = formData.get('subscriptions');
                    this.formData.start_date = formData.get('start_date');
                    this.formData.end_date = formData.get('end_date');

                    // Generate a tenant ID on the client side for preview
                    // Format: 5-digit number (10001)
                    const roomNum = formData.get('room_number') || '0';
                    // Create a 5-digit ID starting with 1, followed by room number padded with zeros
                    const paddedRoomNum = roomNum.toString().padStart(4, '0');
                    this.formData.tenant_id = `1${paddedRoomNum}`.slice(0, 5);

                    // Ensure tenant_id is set and not empty
                    if (!this.formData.tenant_id) {
                        this.formData.tenant_id = `1${paddedRoomNum}`.slice(0, 5);
                    }

                    // Show confirmation modal
                    this.confirmation = true;
                },
                submitForm() {
                    // Add tenant_id as a hidden field to the form
                    const form = document.getElementById('tenantForm');

                    // Check if tenant_id hidden field already exists
                    let tenantIdField = form.querySelector('input[name="tenant_id"]');
                    if (!tenantIdField) {
                        tenantIdField = document.createElement('input');
                        tenantIdField.type = 'hidden';
                        tenantIdField.name = 'tenant_id';
                        form.appendChild(tenantIdField);
                    }
                    tenantIdField.value = this.formData.tenant_id;

                    // Submit the form
                    form.submit();
                },
                showArchiveConfirmation(tenantId) {
                    this.selectedTenantId = tenantId;
                    this.archiveConfirmation = true;
                },
                archiveTenant() {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.archive-tenant', ':id') }}'.replace(':id', this.selectedTenantId);

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                },
                showExtendModal(tenantId, endDate) {
                    this.selectedTenantId = tenantId;
                    this.currentEndDate = endDate;
                    this.newEndDate = '';
                    this.extendModal = true;
                },
                extendTenant() {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.extend-tenant', ':id') }}'.replace(':id', this.selectedTenantId);

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Add new end date
                    const newEndDateInput = document.createElement('input');
                    newEndDateInput.type = 'hidden';
                    newEndDateInput.name = 'new_end_date';
                    newEndDateInput.value = this.newEndDate;
                    form.appendChild(newEndDateInput);

                    document.body.appendChild(form);
                    form.submit();
                },
                toggleNotificationModal() {
                    this.isNotificationModalOpen = !this.isNotificationModalOpen;
                    this.isOpen = false;
                },
                toggleProfileModal() {
                    this.isProfileModalOpen = !this.isProfileModalOpen;
                    this.isOpen = false;
                },
                toggleStudentinfo() {
                    this.isStudentInfoOpen = true;
                },
                handleDone() {
                    this.isProfileModalOpen = false;
                    this.isStudentInfoOpen = false;
                    this.isRegularInfoOpen = false;
                    this.isVIPInfoOpen = false;
                    alert('Changes saved successfully!');
                },
                toggleModal(modalName) {
                    this[modalName] = !this[modalName];
                },
                handleClickOutside(event) {
                    if (this.$refs.appContainer && !this.$refs.appContainer.contains(event.target)) {
                        const dropdown = this.$el.querySelector('.relative');
                        if (dropdown && !dropdown.contains(event.target)) {
                            this.isOpen = false;
                        }
                    }
                },
                updateTime() {
                    const now = new Date();
                    this.time.hours = now.getHours().toString().padStart(2, '0');
                    this.time.minutes = now.getMinutes().toString().padStart(2, '0');
                    this.time.seconds = now.getSeconds().toString().padStart(2, '0');

                    this.formattedDate = now.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },
                filterTenants(filter) {
                    if (filter) {
                        this.currentFilter = filter;
                    }

                    // First filter by subscription type
                    let result = this.tenants;
                    if (this.currentFilter !== 'all') {
                        result = result.filter(tenant => tenant.subscriptions === this.currentFilter);
                    }

                    // Then filter by search query if it exists
                    if (this.searchQuery.trim() !== '') {
                        const query = this.searchQuery.toLowerCase().trim();
                        result = result.filter(tenant =>
                            (tenant.tenant_id && tenant.tenant_id.toLowerCase().includes(query)) ||
                            (tenant.tenant_name && tenant.tenant_name.toLowerCase().includes(query))
                        );
                    }

                    this.filteredTenants = result;

                    // Update isEmpty based on filtered results
                    this.isEmpty = result.length === 0;
                    // Update ShowTenants to be the opposite of isEmpty
                    this.ShowTenants = !this.isEmpty;
                },
                clearSearch() {
                    this.searchQuery = '';
                    this.filterTenants(this.currentFilter);
                },
                showDeleteConfirmation(tenantId) {
                    this.selectedTenantId = tenantId;
                    this.isDeleteConfirmationOpen = true;
                    this.deleteReason = '';
                },
                confirmDeletion() {
                    if (!this.deleteReason.trim()) {
                        alert('Please provide a reason for deletion.');
                        return;
                    }

                    // Create and submit form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/delete-tenant/${this.selectedTenantId}`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfToken);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = this.deleteReason;
                    form.appendChild(reasonInput);

                    document.body.appendChild(form);
                    form.submit();
                },
                showAlert(message, type = 'success') {
                    this.notificationMessage = message;
                    this.notificationType = type;
                    this.showNotification = true;
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000); // Auto-hide after 3 seconds
                },
                async submitForm() {
                    try {
                        const response = await axios.post('/api/tenants', this.formData);

                        if (response.data.success) {
                            this.showAlert(response.data.message, 'success');

                            // Reset form
                            this.formData = {
                                tenant_name: '',
                                tenant_contact: '',
                                total_occupants: '',
                                room_number: '',
                                subscriptions: '',
                                start_date: this.minStartDate,
                                end_date: '',
                                tenant_id: 'Will be generated',
                                password: 'password123',
                            };

                            // Close modals
                            this.confirmation = false;
                            this.isAddTenant = false;

                            // Refresh the page to show the new tenant
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            this.showAlert(response.data.message || 'An error occurred', 'error');
                        }
                    } catch (error) {
                        console.error(error); // for debugging

                        // Graceful error message
                        const message = error.response?.data?.message ||
                            (error.response?.data?.errors ? Object.values(error.response.data.errors).flat().join('\n') : 'An error occurred.');

                        this.showAlert(message, 'error');
                    }
                },


                // New method to filter rooms that have no tenants
                // async filterRoomsWithNoTenants() {
                //     try {
                //         const response = await fetch('/api/available-rooms');
                //         const data = await response.json();
                //         this.roomsWithNoTenants = data;
                //     } catch (error) {
                //         console.error('Failed to fetch rooms:', error);
                //     }
                // },

                // fetchAvailableRooms() {
                //     axios.get('/api/available-rooms')
                //         .then(response => {
                //             this.availableRooms = response.data;
                //         })
                //         .catch(error => {
                //             console.error('Error fetching rooms:', error);
                //         });
                // },
                // onRoomSelect() {
                //     this.$emit('room-selected', this.selectedRoom);
                // }

                // fetchAvailableRooms() {
                //     // Example using axios
                //     axios.get('/api/available-rooms')
                //         .then(response => {
                //             console.log('API Response:', response.data);
                //             this.availableRooms = response.data;
                //         })
                //         .catch(error => {
                //             console.error('Error fetching rooms:', error);
                //         });
                // }
                async fetchAvailableRooms() {
                    try {
                        const response = await fetch('/api/available-rooms');
                        this.availableRooms = await response.json();
                    } catch (error) {
                        console.error('Error fetching rooms:', error);
                    }
                }


            },

            mounted() {
                document.addEventListener('click', this.handleClickOutside);
                this.updateTime();
                setInterval(this.updateTime, 1000);

                // ✅ Optional fallback for Flowbite date picker
                const dateRangeEl = document.getElementById('date-range-picker');
                if (dateRangeEl && window.DateRangePicker) {
                    new DateRangePicker(dateRangeEl, {
                        format: 'yyyy-mm-dd'
                    });
                }


                const today = new Date();
                const year = today.getFullYear();
                const month = (today.getMonth() + 1).toString().padStart(2, '0');
                const day = today.getDate().toString().padStart(2, '0');
                this.minStartDate = `${year}-${month}-${day}`;

                this.formData.start_date = this.minStartDate;


                const startDateObj = new Date(this.formData.start_date);
                startDateObj.setDate(startDateObj.getDate() + 30);

                const endYear = startDateObj.getFullYear();
                const endMonth = (startDateObj.getMonth() + 1).toString().padStart(2, '0');
                const endDay = startDateObj.getDate().toString().padStart(2, '0');
                this.formData.end_date = `${endYear}-${endMonth}-${endDay}`;



                @if (session('success'))
                    this.notificationMessage = @json(session('success'));
                this.notificationType = 'success';
                this.showNotification = true;
                setTimeout(() => this.showNotification = false, 3000);
            @elseif(session('error'))
                this.notificationMessage = @json(session('error'));
                this.notificationType = 'error';
                this.showNotification = true;
                setTimeout(() => this.showNotification = false, 3000);
            @endif


            // this.filterRoomsWithNoTenants();
                this.fetchAvailableRooms();
            },
            components: {
                notification: {
                    props: ['message', 'type'],
                    template: `
                        <div class="fixed top-4 right-4 px-6 py-3 rounded-md shadow-md max-w-xs text-center z-50 transition-all duration-300"
                             :class="{
                    'bg-green-600 text-white': type === 'success',
                    'bg-red-600 text-white': type === 'error',
                    'opacity-0 translate-y-2': !show,
                    'opacity-100 translate-y-0': show
                }"
                             v-show="show"
                             @click="$emit('close')">
                            @{{ message }}
                <button class="ml-2">×</button>
                        </div>
                    `,
                    data() {
                        return {
                            show: true
                        }
                    }
                }
            },


            beforeUnmount() {
                document.removeEventListener('click', this.handleClickOutside);
            },

        }).mount('#app');
    </script>



    <style>
        /* Simple fade animation */
        .fade-enter-active,
        .fade-leave-active {
            transition: all 0.2s ease;
        }

        .fade-enter-from,
        .fade-leave-to {
            opacity: 0;
            transform: scale(0.95);
        }

        /* Custom CSS to hide scrollbar */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
