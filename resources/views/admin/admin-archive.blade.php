<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Tenant</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.2.1/dist/datepicker.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="flex bg-gray-900"
    style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
</body>
<div id="app" class="flex justify-between w-full">
    @if(session('success'))
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-600 text-white px-6 py-3 rounded-md shadow-md max-w-xs text-center z-50 animate-fadeout">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-600 text-white px-6 py-3 rounded-md shadow-md max-w-xs text-center z-50 animate-fadeout">
            {{ session('error') }}
        </div>
    @endif

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
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
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
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
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
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
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
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
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
                        class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-gray-800 rounded hover:bg-white group">
                        <span
                            class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                        <span
                            class="relative w-full text-left text-white transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                                <span>+ Add Tenants</span>
                            </div>
                        </span>
                    </a>
                </li>

                <li class="relative px-3 py-3">
                    <a href="{{ route('admin.archive') }}"
                        class="relative inline-flex items-center w-full justify-start px-3 py-3 overflow-hidden text-sm font-semibold transition-all bg-[#ffc329] rounded hover:bg-white group">
                        <span
                            class="w-48 h-48 rounded rotate-[-40deg] bg-[#ffc329] absolute bottom-0 left-0 -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0"></span>
                        <span
                            class="relative w-full text-left text-gray-900 transition-colors duration-300 ease-in-out group-hover:text-gray-800">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
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

                <button @click="toggleNotificationModal" class="p-2 text-white rounded-full">
                    🔔
                </button>



                <!-- Notification Modal -->
                <div v-if="isNotificationModalOpen" class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                    role="dialog" aria-modal="true" aria-labelledby="modalTitle">
                    <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900">
                        <div class="flex items-start justify-between">
                            <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">
                                Notification
                            </h2>

                            <button type="button" @click="toggleNotificationModal"
                                class="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                                aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4 flex-col space-y-6 max-h-[70vh] overflow-y-auto scrollbar-hide">
                            <!-- Notification items -->
                            <div v-for="n in 3" :key="n"
                                class="max-w-4xl px-8 py-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-light text-gray-600 dark:text-gray-400">Mar 10,
                                        2019</span>
                                    <a class="px-3 py-1 text-sm font-bold text-gray-100 transition-colors duration-300 transform bg-gray-600 rounded cursor-pointer hover:bg-gray-500"
                                        tabindex="0" role="button">Delete</a>
                                </div>

                                <div class="mt-2">
                                    <a href="#"
                                        class="text-xl font-bold text-gray-700 dark:text-white hover:text-gray-600 dark:hover:text-gray-200 hover:underline"
                                        tabindex="0" role="link">Notice</a>
                                    <p class="mt-2 text-gray-600 dark:text-gray-300">Lorem ipsum dolor sit, amet
                                        consectetur adipisicing elit. Tempora expedita dicta totam aspernatur
                                        doloremque.</p>
                                </div>
                            </div>
                        </div>
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
                    <div v-if="isProfileModalOpen" class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                        role="dialog" aria-modal="true" aria-labelledby="modalTitle">
                        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900">
                            <div class="flex items-start justify-between">
                                <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">
                                    Edit Admin Account</h2>
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
                            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Archive</h2>

                            <span
                                class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-[#ffc329]">{{ $archivedTenants?->count() ?? 0 }}

                                Archived</span>
                        </div>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">List of Dormnest Archives</p>
                    </div>

                    <div class="flex items-center mt-4 gap-x-3">



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
                                any tenant. Please try again.</p>
                            <div class="flex items-center mt-4 sm:mx-auto gap-x-3">
                                <button @click="clearSearch"
                                    class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                    Clear Search
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
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left table-fixed">
                                            <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th class="w-25 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Room #</th>
                                                <th class="w-25 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">X-Tenant ID</th>
                                                <th class="w-40 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Name</th>
                                                <th class="w-30 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Phone</th>
                                                <th class="w-30 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Archived At</th>
                                                <th class="w-64 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Reason</th>
                                                <th class="w-35 px-4 py-3.5 font-normal text-gray-500 dark:text-gray-400">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                            @forelse($archivedTenants as $tenant)
                                                <tr>
                                                    <td class="w-24 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $tenant->room_number }}</td>
                                                    <td class="w-28 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $tenant->original_tenant_id }}</td>
                                                    <td class="w-40 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $tenant->name }}</td>
                                                    <td class="w-32 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $tenant->phone }}</td>
                                                    <td class="w-40 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ $tenant->archived_at }}</td>
                                                    <td class="w-64 px-4 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap truncate" title="{{ $tenant->reason }}">
                                                        {{ $tenant->reason }}
                                                    </td>
                                                    <td class="w-40 px-4 py-4 whitespace-nowrap">
                                                        <form method="POST" action="{{ route('admin.delete-archived-tenant', $tenant->id) }}"
                                                              onsubmit="return confirm('Permanently delete this archived tenant?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                                                                Delete Permanently
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                                        No archived tenants found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
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
                // UI States
                isOpen: false,
                isNotificationModalOpen: false,
                isProfileModalOpen: false,
                isStudentInfoOpen: false,
                isRegularInfoOpen: false,
                isVIPInfoOpen: false,
                isAddTenant: false,
                isEmpty: {{ $archivedTenants->isEmpty() ? 'true' : 'false' }},
                ShowTenants: {{ !$archivedTenants->isEmpty() ? 'true' : 'false' }},
                adminTitle: 'Archive',
                tenants: @json($archivedTenants),
                filteredTenants: @json($archivedTenants),
                currentFilter: 'all',
                searchQuery: '',

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
                ]
            };
        },
        methods: {
            toggleDropdown() {
                this.isOpen = !this.isOpen;
            },
            toggledAddTenant() {
                this.isAddTenant = !this.isAddTenant;
            },
            toggledAddSave() {
                this.ShowTenants = !this.ShowTenants;
                this.isEmpty = !this.isEmpty
                this.isAddTenant = !this.isAddTenant;
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
                const dropdown = this.$el.querySelector('.relative');
                if (dropdown && !dropdown.contains(event.target)) {
                    this.isOpen = false;
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
            },
            clearSearch() {
                this.searchQuery = '';
                this.filterTenants(this.currentFilter);
            },
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
        },
        beforeUnmount() {
            document.removeEventListener('click', this.handleClickOutside);
        }
    }).mount('#app');
</script>



<style>
    .animate-fadeout {
        animation: fadeOut 3s ease-in forwards;
    }
    @keyframes fadeOut {
        0% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }
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
