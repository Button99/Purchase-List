<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm, Head } from '@inertiajs/inertia-vue3';
    import useVuelidate from '@vuelidate/core';
    import { helpers } from '@vuelidate/validators';
    import { ref, toRef } from 'vue';

    const isOpenDelete= ref(false);
    const isOpenChangePsw= ref(false);
    const isOpenChangePfp= ref(false);

    const user=defineProps(['user']);
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

    const formPsw= useForm({
        oldPsw: '',
        newPsw: '',
        newPswRetype: ''
    });

    const formImg= useForm({
        image: []
    });

    const formDel= useForm();

    const imgRule= (value) => {
        if(!value) {
            return true;
        }
        return /\.(gif|jpg|jpeg|tiff|png)$/.test(value.name);
    }

    const imgSize= (value) => {
        if(!value) {
            return true;
        }
        return (value.size /1024/1024) < 2;
    }

    const rules= {
        img: {
            imgRule: helpers.withMessage('Not a valid image type (Supported jpg, jpeg, png)', imgRule),
            imgSize: helpers.withMessage('Need to be smaller than 2MB', imgSize)
        }
    }

    const v$= useVuelidate(rules, {
        img: toRef(formImg, 'image')
    });

    function changeImage() {
        formImg.post('profile/' + user.user.id + '/changeImageProfile');
    }

    function destroy() {
        formDel.delete(route('deleteAccount'))
    }

    function changePassword() {
        formPsw.put(route('changePsw'));
    }
</script>
    
<template>
    <Head title="Settings" />

    <component :is="component">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Settings
            </h2>
        </template>
        <div class="py-12" v-if="user.user.google_id === null && user.user.github_id === null">
            <div class="max-w-7xl mx-auto sm:px-6 rounded-lg lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6  bg-[#F3FAFC] border-b ">
                        <ul role="list" class="divide-y divide-black-300 dark-divide-black-600">
                            <li class="py-2 sm:py-2"><p class="text-lg text-[#353535] truncate">Name: {{user.user.name}}</p></li>
                            <li class="py-2 sm:py-2"><p class="text-lg text-[#353535] truncate" >Email: {{user.user.email}}</p></li>
                            <li class="py-2 sm:py-2">
                                <button type="button" class="inline-block px-6 py-2.5 bg-[#6096B4] text-white font-bold text-2xs leading-tight uppercase rounded shadow-md hover:bg-[#43697E] hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition" @click="isOpenChangePfp = true">Change Your Profile picture</button>
                                <div class="flex">
                                    <div v-show="isOpenChangePfp" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
                                        <div class="max-w-2xl p-6 mx-4 bg-white rounded-md shadow-xl">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-2xl text-[#353535]">Change Your Profile Picture</h3>
                                            </div>
                                            <div class="mt-4 items-center justify-between text-center">
                                                <form>
                                                    <label class="block mb-2 text-sm font-medium text-dark-900 dark:text-dark-400 text-[#353535]" for="file_input">Upload image</label>
                                                    <input class="block w-full text-md border rounded-md cursor-pointer bg-gray-50 text-[#353535] focus:outline-none dark:bg-gray-300 " aria-describedby="file_input_help" id="file_input" type="file" v-on:change="formImg.image= $event.target.files[0]" @blur="v$.img.$touch()">
                                                    <p class="mt-1 text-sm text-[#353535]" id="file_input_help">PNG, JPG (MAX. 2MB).</p>
                                                    <div v-if="v$.img.$errors" v-for="error of v$.img.$errors" :key="error.$uid" class="text-red-600 font-bold">{{ error.$message}}</div>
                                                </form>
                                                <br />
                                                <button @click="isOpenChangePfp = false" class="px-6 py-2 ml-2 text-yellow-100 bg-yellow-600 rounded">
                                                    <p class="font-bold text-white">Cancel</p>
                                                </button>
                                                <button @click="changeImage" class="px-6 py-2 ml-2 text-red-100 bg-[#43697E] hover:bg-[#4C7890] rounded">
                                                    <p class="font-bold text-white">Change Image</p>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2 sm:py-2">
                                <button type="button" class="inline-block px-6 py-2.5 bg-[#6096B4] text-white font-bold text-2xs leading-tight uppercase rounded shadow-md hover:bg-[#43697E] hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition" @click="isOpenChangePsw = true">Change Your Password</button>
                                <div class="flex">
                                    <div v-show="isOpenChangePsw" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
                                        <div class="max-w-2xl p-6 mx-4 bg-white rounded-md shadow-xl">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-2xl text-[#353535]">Change Your Password</h3>
                                            </div>
                                            <div class="mt-4 items-center justify-between text-center">
                                                <form>
                                                    <label for="old-password" class="text-lg text-[#353535]">Old Password: </label>
                                                    <input type="password" name="old-password" class="mt-1 block w-full" v-model="formPsw.oldPsw"/><br />
                                                    <label for="new-password" class="text-lg text-[#353535]">New Password: </label>
                                                    <input type="password" name="new-password" class="mt-1 block w-full" v-model="formPsw.newPsw" /><br />
                                                    <label for="new-passwordRetype" class="text-lg text-[#353535]">New Password Retype: </label>
                                                    <input type="password" name="new-passwordRetype" class="mt-1 block w-full" v-model="formPsw.newPswRetype"/><br />
                                                </form>
                                                <br />
                                                <button @click="isOpenChangePsw = false" class="px-6 py-2 ml-2 font-bold text-yellow-100 bg-yellow-600 rounded">
                                                    <p>Cancel</p>
                                                </button>
                                                <button @click="changePassword" class="px-6 py-2 ml-2 text-white font-bold bg-[#43697E] hover:bg-[#4C7890] rounded">
                                                    <p>Done</p>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2 sm:py-2">
                                <button type="button" @click="isOpenDelete = true" class="inline-block px-6 py-2.5 bg-[#FF3B3F] text-white font-bold text-2xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition">Delete Your Account</button>
                                <div class="flex">
                                    <div v-show="isOpenDelete" class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
                                        <div class="max-w-2xl p-6 mx-4 bg-white rounded-md shadow-xl">
                                            <div class="flex items-center justify-between">
                                                <h3 class="text-2xl text-[#353535]">Delete Your Account</h3>
                                            </div>
                                            <div class="mt-4 items-center justify-between text-center">
                                                <p class="text-[#353535] font-extrabold">You can't undo this action.</p>
                                                <br />
                                                <button @click="isOpenDelete = false" class="px-6 py-2 ml-2 text-red-100 bg-[#FF3B3F] hover:bg-[#CC2F32] font-bold rounded">
                                                    NO
                                                </button>
                                                <button @click="destroy" class="px-6 py-2 ml-2 text-blue-100 bg-[#6096B4] hover:bg-[#4C7890] rounded font-bold">
                                                    YES
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12" v-if="!user.user.google_id || !user.user.github_id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
                </div>
            </div>
        </div>

    </component>
</template>
