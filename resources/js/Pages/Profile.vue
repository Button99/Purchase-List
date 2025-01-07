<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import { helpers, maxLength, minLength, required } from '@vuelidate/validators';
    import useVuelidate from '@vuelidate/core';
    import { toRef, reactive, ref } from 'vue';
    import axios from 'axios';

    const state= reactive({
        showField: false,
    });

    let usrId= ref();

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

    const data= useForm({
        name: '',
        bio: '',
        image: ''
    });
    
    const updateForm= useForm({
        name: '',
        bio: ''
    });

    axios.get('profile/' + route().params.id)
        .then((res) => {
            data.name= res.data.user.name;
            data.bio= res.data.user.bio;
            data.image= res.data.image;
            usrId= res.data.sameUsr;
            updateForm.name= data.name;
            updateForm.bio= data.bio;
        }).catch((err) => {
            alert(err);
        });

    const updateProfile = () => {
        v$.value.$touch();
        if(v$.value.$invalid) {
            return alert('You have errors...\n Please try again.');
        }
        updateForm.put('/profile/update');
    }

    const rules= {
        name: {required: helpers.withMessage('This Field is required', required),
            maxLength: helpers.withMessage('Your name should be smaller!', maxLength(100)),
            minLength: helpers.withMessage('Your name should be bigger!', minLength(3))
        },
        bio: {
            required: helpers.withMessage('This field is required', required),
            maxLength: helpers.withMessage('Your bio should be smaller!', maxLength(300))
        }
    };

    const v$= useVuelidate(rules, {
        name: toRef(updateForm, 'name'),
        bio: toRef(updateForm, 'bio')
    });

</script>

<template>
    <Head title="Profile" />
    <component :is="component">
        <div class="py-11 lg:px-12">
            <div class="flex flex-col bg-white rounded-lg border shadow-md md:flex-row md:max-w-xl bg-[#F3FAFC] text-[#353535]">
                <img class="object-cover w-full h-96 rounded-t-lg md:h-auto md:w-48 md:rounded-none md:rounded-l-lg transition-all duration-300 rounded-lg blur-sm hover:blur-none" :src="data.image.path" alt="user picture">

                <div class="flex flex-col justify-between p-4 leading-normal bg-[#F3FAFC] text-[#353535]">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight float-right" v-show="!state.showField">{{data.name}}</h5>
                    <input v-if="usrId == true" v-show="state.showField" type="text" v-model="updateForm.name" class="mt-1 block w-full" @blur="v$.name.$touch()"/>
                    <div v-if="v$.name.$errors && state.showField" v-for="error of v$.name.$errors" class="text-red-600 font-bold">{{error.$message}}</div>
                    
                    <p class="mb-3 font-normal" v-show="!state.showField">Bio: {{data.bio}}</p>
                    <input v-if="usrId == true" type="text" v-show="state.showField" v-model="updateForm.bio" class="mt-1 block w-full" @blur="v$.bio.$touch()"/>
                    <div v-if="v$.bio.$errors && state.showField" v-for="error of v$.bio.$errors" class="text-red-600 font-bold">{{error.$message}}</div>
                    Available lists:
                    <div class="text-[#808080] underline" v-for="list in lists">
                        <Link :href="route('displayItems', list.id)" v-if="list.public == true"> {{list.name}}</Link>
                    </div>
                </div>
                <button v-if="usrId == true" @click="state.showField = !state.showField" v-show="!state.showField">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                </button>
                <button v-if="usrId == true" @click="updateProfile" v-show="state.showField">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>

                </button>
                <button v-if="usrId == true" @click="state.showField = !state.showField" v-show="state.showField">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>
        </div>
    </component>
</template>
