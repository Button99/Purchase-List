<script setup>
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3'
import axios from 'axios';

let input= ref('');
const showingNavigationDropdown = ref(false);
let usernames= ref([]);

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

watch(input, (value) => {
    axios.get('/users/search')
        .then((res) => {
            usernames.value= res.data.users.data;
        }).catch((err) => {
            alert(err);
        })
});

</script>

<template>
    <!-- TODO: Implement it better -->
    <component :is="component">
        <Head title="Search" />

        <form action="GET">
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
        </form>                
    </component>
</template>
