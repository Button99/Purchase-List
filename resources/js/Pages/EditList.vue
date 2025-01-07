<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import CheckboxVue from '@/Components/Checkbox.vue';
    import {useVuelidate} from '@vuelidate/core';
    import {required, maxLength, minLength, between, helpers} from '@vuelidate/validators';
    import { toRef, ref } from 'vue';

    const props= defineProps(['user']);
    const form= useForm({
        id: '',
        name: '',
        tag: '',
        public: 0
    });

    axios.get('/itemList/show/' + route().params.id)
        .then((res) => {
            form.id= res.data.id;
            form.name= res.data.name;
            form.tag= res.data.tag;
            form.public= res.data.public;
        }).catch((err) => {
            alert(err);
        });

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
        
    const submit = () => {
        v$.value.$touch();
        if(v$.value.$invalid) {
            return alert('You have errors in the form!');
        }
        form.put('/itemList/update/' + form.id)
            .then((res) => {}).catch((err) => {alert(err);})
    };

    const destroy = (id) => {
        form.delete('/itemList/delete/' + id)
            .then((res) => {}).catch((err) => {alert(err);})
    }

    const rules= {
        name: {required: helpers.withMessage('This field is required', required),
            maxLength:  helpers.withMessage('Too many characters', maxLength(100)),
            minLength: helpers.withMessage('Needs to have more characters', minLength(2))
        },
        tag: {maxLength: helpers.withMessage('Too many characters', maxLength(600))},
        public: {between: helpers.withMessage('Wrong value', between(0, 1))}
    };

    const v$= useVuelidate(rules, {
        name: toRef(form, 'name'),
        tag: toRef(form, 'tag'),
        public: toRef(form, 'public')
    });
</script>
    
    <template>
        <Head title="Edit List" />
    
        <component :is="component">
            <template #header>
                <h2 class="font-semibold text-xl text-[#353535] leading-tight">
                    Edit List
                </h2>
            </template>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-[#E2E9E9] border-b border-gray-200">
                            <form @submit.prevent="submit()">
                                <label for="list-name" class="text-[#353535] text-lg">Name:</label>
                                <input type="text" name="list-name" class="mt-1 block w-full" v-model="form.name" @blur="v$.name.$touch()"/><br />
                                <div v-if="v$.name.$errors" v-for="error of v$.name.$errors" :key="error.$uid" class="text-red-600 font-bold">{{ error.$message}}</div>

                                <label for="item-tag" class="text-[#353535] text-lg">Tag:</label>
                                <input type="text" name="list-tag" v-model="form.tag" class="mt-1 block w-full" @blur="v$.tag.$touch()"/><br />
                                <div v-if="v$.tag.$errors" v-for="error of v$.tag.$errors" :key="error.$uid" class="text-red-600 font-bold">{{ error.$message}}</div>

                                <label for="list-public" class="text-[#353535] text-lg" >Public:</label><br />
                                <CheckboxVue v-if="form.public == 1" class="form-check-input appearance-none h-8 w-8 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-center mr-2 cursor-pointer" v-model="form.public" :value="form.public" :v-bind="form.public" checked @blur="v$.public.$touch()"></CheckboxVue>
                                <CheckboxVue v-if="form.public == 0" class="form-check-input appearance-none h-8 w-8 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-center mr-2 cursor-pointer" v-model="form.public" :value="form.public" @blur="v$.public.$touch()"></CheckboxVue><br /><br />                                
                                <div v-if="v$.public.$errors" v-for="error of v$.public.$errors" :key="error.$uid" class="text-red-600 font-bold">{{ error.$message}}</div>

                                <button type="button" @click="submit" class="rounded hover:rounded-md m-4 px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase font-bold shadow-md bg-[#6096B4] hover:bg-[#4C7890] hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition">Update List</button>
                                <button type="button" @click="destroy(form.id)" class="rounded hover:rounded-md m-4 px-6 py-2.5 text-white font-medium text-xs leading-tight uppercase shadow-md hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 bg-[#FF3B3F] hover:bg-[#CC2F32] font-bold active:shadow-lg transition">Delete List</button>
                            </form>
                        </div>
                    </div>
                    <br />
                </div>
            </div>
        </component>
</template>
