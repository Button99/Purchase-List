<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import {ref} from 'vue';
    import axios from 'axios';

    const props= defineProps(['user']);
    const lists= ref();
    let isAdmin= false;
    let component= AuthenticatedLayout;
    
    axios.get('/isAdmin')
        .then((res) => {
            isAdmin.value= res.data;
            if(isAdmin.value) {
                component= AdminLayout;
            }
        }).catch((err) => {
            console.log(err);
    });

    axios.get('/itemList/getLists').then((res) => {
        lists.value= res.data;
    }).catch((err) => {
        alert(err);
    });
</script>

<template>
    <Head title="Show Lists" />

    <component :is="component">
        <template #header>
            <h2 class="font-semibold text-xl text-[#353535] leading-tight">
                Show Lists
            </h2>
        </template>

        <div class="py-17 flex block-inline grid md:grid-cols-4 md:gap-4 sm:grid-cols-2 md:gap-2">
            <div class="max-w-xs m-4 rounded overflow-hidden flex" v-for="listData in lists">
                <div class="md:px-6 md:py-4 sm:px-5 sm:py-6 bg-[#E2E9E9]">
                    <div class="font-bold text-xl mb-2 text-[#353535]">{{listData.name}}</div>
                        <p class="text-[#353535]">
                            {{listData.tag}}
                        </p>
                        <p class="text-[#353535] text-base">
                            <Link :href="route('displayItems', listData.id)" class="float-left m-2 text-[#353535]">Show Items</Link>
                            <Link :href="route('editList', listData.id)" class="float-right m-2 text-[#353535]">List Settings</Link>
                        </p>
                    </div>
                </div>
            </div>
        </component>
</template>