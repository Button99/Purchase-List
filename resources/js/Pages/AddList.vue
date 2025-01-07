<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm } from '@inertiajs/inertia-vue3'
    import {useVuelidate} from '@vuelidate/core';
    import {required, maxLength, minLength, between, helpers} from '@vuelidate/validators';
    import { toRef } from 'vue';

    const props= defineProps(['user']);
    const form= useForm({
        name: '',
        tag: '',
        public: 0
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
        form.post('addList/store');
    };

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
        <Head title="Add Item" />
    
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create new List
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b bg-[#F3FAFC] text-[#353535] text-lg">
                            <form @submit.prevent="submit()">
                                <label for="list-name">Name:</label>
                                <input type="text" name="list-name" class="mt-1 block w-full" v-model="form.name" @blur="v$.name.$touch()"/><br />
                                <div v-if="v$.name.$errors" v-for="error of v$.name.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="item-tag">Tag:</label>
                                <input type="text" name="list-tag" v-model="form.tag" class="mt-1 block w-full" @blur="v$.tag.$touch()"/><br />
                                <div v-if="v$.tag.$errors" v-for="error of v$.tag.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="list-public" >Public:</label><br />
                                <input class="form-check-input appearance-none h-8 w-8 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-center mr-2 cursor-pointer" type="checkbox" value="1" id="flexCheckDefault" v-model="form.public" @blur="v$.public.$touch()"><br /><br />
                                <div v-if="v$.public.$errors" v-for="error of v$.public.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-1">Insert List</button>
                            </form>
                        </div>
                    </div>
                    <br />
                </div>
            </div>
        </AuthenticatedLayout>
</template>
