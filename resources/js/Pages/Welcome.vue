<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Footer from '@/Components/Footer.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />
    <div class="flex flex-wrap">
        <div class="relative w-full items-top justify-center sm:items-center mb-4">
            <div v-if="canLogin" class=" flex-row fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 dark:text-gray-500 underline flex-end">Dashboard</Link>
                <Link v-if="$page.props.auth.user" :href="route('faq')" class="text-sm text-gray-700 dark:text-gray-500 underline flex-end">Faq</Link>

                <template v-else>
                    <Link :href="route('login')" class="text-sm dark:text-gray-500 underline">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>

                    <Link :href="route('faq')" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Faq</Link>

                </template>
            </div>
        </div>
    </div>
    <div class="grid h-[80vh] place-items-center">
        <p class="text-5xl text-[#666666] text-center">Welcome to Purchase List <br/>
            <span class="text-sm ">Here you can add every thing you want to buy for free!</span>
        </p>
    </div>
    <Footer></Footer>
</template>
