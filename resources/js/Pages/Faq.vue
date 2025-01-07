<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import Accordion from '@/Components/Accordion.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

var data={
    "test": [
    {
        "headline": "What is PurchaseList",
        "content": "PurchaseList is a place where you can store all the products that you want to buy for free! You can organize your items by creating lists and putting them there."
    },
    {
        "headline": "Who we are?",
        "content": 'PurchaseList list team is one man team! So feel free to drop your opinion about the  website here -> <a href="https://www.linkedin.com/in/christos-koumpis-9785811a8" target="_blank" class="text-blue-500">Linkedin</a>',
    },
    {
        "headline": "Is there any cost or subscription?",
        "content": "No, PurchaseList is absolutely free for everyone."
    },
    {
        "headline": "I found a bug, what should I do?",
        "content": "If you found any bugs you can directly send me a message at LinkedIn and inform me about it."
    },
    {
        "headline": "Are they gonna be more updates of PurchaseList?",
        "content": "Of course! The idea of PurchaseList has just started! Greater things will come soon."
    }
]};

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
    <div class="w-1/2 m-auto pt-10" v-for="text in data.test">
        <Accordion :headline="text.headline" :content="text.content"/>
    </div>
    <Footer></Footer>
  </template>