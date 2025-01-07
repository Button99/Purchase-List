<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    const props= defineProps(['user']);
    
</script>


<template>
    <Head title="Admin Panel" />

    <component :is="AdminLayout">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Admin Layout
            </h2>
        </template>
        <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-[#e2e9e9] border-b text-[#353535] text-lg">
                    Welcome admin {{user}}! What do you want to view.
                </div>
                <div class="mx-auto px-auto max-w-xl sm:px-6 lg:px-7 sm:flex-row flex flex-nowrap">
                    <Link :href="route('viewUsers')" class="text-sm space-x-0.5">
                        <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-2 m-6 flex shrink-0">Search for Users</button>
                    </Link>
                    <Link :href="route('viewLists')" class="text-sm text-gray-700 dark:text-gray-500 space-x-0.5">
                        <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-2 m-6 object-center flex-none shrink-0 ">Search for Lists</button>
                    </Link>
                </div><br/><br/><br/>
            </div>
            <br />
        </div>
    </div>
    </component>
    
</template>