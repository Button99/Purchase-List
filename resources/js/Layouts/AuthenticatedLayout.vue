<script setup>
import { ref, watch } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Footer from '@/Components/Footer.vue';

const showingNavigationDropdown = ref(false);
const user= defineProps(['user']);
let userId= ref('');
axios.get('/id')
    .then((res) => {
        userId.value= res.data;
    }).catch((err) => {
        console.log(err);
    });

let input= ref('');
let usernames= ref([]);

watch(input, (value) => {

    axios.get('/users/search')
        .then((res) =>
            usernames.value= res.data.users.data
        ).catch((err) => {
            alert(err);
        })
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-[#C4CAD0]">
            <nav class="bg-[#C4CAD0] border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-30" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-[#353535]">
                                    Dashboard
                                </NavLink>
                                <NavLink :href="route('profile', {'id': userId})" :active="route().current('profile')" class="text-[#353535]">
                                    Profile
                                </NavLink>
                                <NavLink :href="route('settings')" :active="route().current('settings')" class="text-[#353535]">
                                    Settings
                                </NavLink>
                                <NavLink :href="route('faq')" :active="route().current('faq')" class="text-[#353535]">
                                    Faq
                                </NavLink>
                                <NavLink :href="route('logout')" method="post" :active="route().current('logout')" class="text-[#353535]">
                                    Logout
                                </NavLink>
                                <form class="ml-[300px] h-3 mt-3" action="GET">
                                    <div class="flex space-x-4 h-10">
                                        <div class="flex rounded-sm w-full h-15 justify-items-center">
                                            <div class="w-1/2 items-center justify-center ml-[300px]">
                                                <input type="text" x-on:click="open!=open" class="w-full  rounded-lg h-15" placeholder="Search user" v-model="input"/><br/>

                                                <ul x-show="open" x-on:click.outside="open = !open"  x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate"
                                                    x-transition:enter-end="opacity-100 translate"
                                                    x-transition:leave="transition ease-in duration-300"
                                                    x-transition:leave-start="opacity-100 translate"
                                                    x-transition:leave-end="opacity-0 translate"  class="justify-items-center">
                                                    <template v-for="usr in usernames" :key="usr">
                                                        <li class="w-full text-gray-700 p-4 mt-2 bg-white rounded-lg">
                                                            <Link :href="route('profile', {'id': usr.id} )">
                                                                <button> {{ usr.name }} </button>
                                                            </Link>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('profile')" :active="route().current('profile')">
                            Profile
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('settings')" :active="route().current('settings')">
                            Settings
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('faq')" :active="route().current('faq')">
                            Faq
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('search')" :active="route().current('search')">
                            Search
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-[#E2E9E9] shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#353535]">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main >
                <slot />
            </main>
            <Footer></Footer>
        </div>
    </div>
</template>
