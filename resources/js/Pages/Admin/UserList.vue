<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';

    const props= defineProps(['users']);
    const form= useForm({
        id: null
    });

    function destroy(id) {
        form.delete(route('deleteUser', id));
    }

    function addWarning(id) {
        form.id= id;
        form.post(route('addWarning'));
    }
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
                <div v-for="user in users" class="p-3 bg-[#e2e9e9] border-b text-[#353535] text-lg">
                    Name: {{ user.name }} <br /> Bio: {{ user.bio }} <br /> Created At: {{ user.created_at }}
                    <button type="button" @click="destroy(user.id)" class="inline-block  px-6 py-2.5 bg-[#FF3B3F] hover:bg-[#CC2F32] font-bold text-white text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition">Delete</button>
                    <button type="button" @click="addWarning(user.id)" class="inline-block  px-6 py-2.5 bg-yellow-600  text-white font-bold text-xs leading-tight uppercase rounded shadow-md hover:bg-yellow-700 hover:shadow-lg focus:bg-yellow-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-yellow-800 active:shadow-lg transition m-3">Make a warning</button>
                </div>
            </div>
        </div>
    </component>
</template>