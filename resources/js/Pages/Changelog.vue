<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import Footer from '@/Components/Footer.vue';
</script>

<template>
        <nav class="bg-[#C4CAD0] border-b ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo class="block h-9 w-30" />
                        </Link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <NavLink :href="route('dashboard')" class="text-[#353535]">
                            Go back
                        </NavLink>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="m-auto pt-10 w-1/2">
        <p class="text-3xl justify-center flex">Version</p> <br />
        <p class="flex justify-center">v1.0.0 - Release</p>
        <hr />
    </div>
    <Footer></Footer>
</template>