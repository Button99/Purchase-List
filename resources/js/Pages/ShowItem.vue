<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Link, useForm} from '@inertiajs/inertia-vue3';
    import CheckboxVue from '@/Components/Checkbox.vue';

    const props= defineProps(['item', 'picture']);
    const form= useForm();

    function destroy(id) {
        form.delete(route('item.delete', id));
    }

    function newTab(link) {
        window.open(link, '_blank');
    }
</script>
    
<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-200 border-b border-gray-600">
                        <img :src="'/' + picture.path" class="p-1 mr-3 bg-white border rounded max-w-sm h-[23vh] float-left" /> <br />
                        <span class="text-[#353535] text-lg">Name: {{item.name}}</span> <br />
                        <span class="text-[#353535] text-lg">Price: {{item.price}}</span> <br />
                        <span class="text-[#353535] text-lg">Link:</span><button @click="newTab(item.link)" class="text-blue-700"> {{item.link}} </button><br />
                        <span class="text-[#353535] text-lg">Has Been Bought: </span><CheckboxVue v-if="item.has_been_bought == 1" :v-model="item.has_been_bought" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2" :value="item.has_been_bought" disabled checked></CheckboxVue>
                            <CheckboxVue v-if="item.has_been_bought == 0" :v-model="item.has_been_bought" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2" :value="item.has_been_bought" disabled></CheckboxVue><br /><br />
                        <Link :href="route('itemPage', item.id)" ><button type="button" class="inline-block px-6 py-2.5 bg-yellow-600 text-white font-bold text-xs leading-tight uppercase rounded shadow-md hover:bg-yellow-700 hover:shadow-lg focus:bg-yellow-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-yellow-800 active:shadow-lg transition m-3">Edit</button></Link>
                        <button type="button" @click="destroy(item.id)" class="inline-block px-6 py-2.5 bg-[#FF3B3F] hover:bg-[#CC2F32] font-bold text-white text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <Link :href="route('dashboard')" class="text-[#353535]">Return back</Link>
    </AuthenticatedLayout>
</template>