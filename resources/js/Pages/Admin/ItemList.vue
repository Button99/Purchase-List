<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    const props= defineProps(['lists']);

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
            </div>
        </div>
    </component>
</template>