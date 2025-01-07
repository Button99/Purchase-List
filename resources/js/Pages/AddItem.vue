<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { useForm, Head } from '@inertiajs/inertia-vue3'
    import {useVuelidate} from '@vuelidate/core';
    import {required, maxLength, minLength, minValue, numeric, url, between, helpers} from '@vuelidate/validators';
    import axios from 'axios';
    import { toRef, ref } from 'vue';

    const props= defineProps(['user']);
    const form= useForm({
        name: '',
        description: '',
        price: '',
        link: '',
        lists: 'Choose a list',
        image: [],
        hasBeenBought: 0,
    });

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

    const submit = () => {
        v$.value.$touch();
        if(v$.value.$invalid) {
            return alert('You have errors in the form!');
        }
        form.post('addItem/store');
    };

    const imgRule= (value) => {
        if (!value) {
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
        name: {required: helpers.withMessage('This field is required', required),
            maxLength:  helpers.withMessage('Too many characters', maxLength(100)),
            minLength: helpers.withMessage('Needs to have more characters', minLength(2))
        },
        description: {maxLength: helpers.withMessage('Too many characters', maxLength(600))},
        price: {required: helpers.withMessage('This field is required', required),
            minValue: helpers.withMessage('Price must be greater than 0', minValue(0)),
            numeric: helpers.withMessage('Needs to be numeric', numeric)},
        link: {required: helpers.withMessage('This field is required', required),
        url: helpers.withMessage('Invalid url type', url)},
        img: {imgRule: helpers.withMessage('Not valid image type (Supported jpeg, png, jpg)', imgRule),
            imgSize: helpers.withMessage('Need to be smaller than 2MB', imgSize)        
    },
        hasBeenBought: {between: helpers.withMessage('Wrong value', between(0, 1))},
    };

    const v$= useVuelidate(rules, {
        name: toRef(form, 'name'),
        description: toRef(form, 'description'),
        price: toRef(form, 'price'),
        link: toRef(form, 'link'),
        lists: toRef(form, 'lists'),
        img: toRef(form, 'image'),
        hasBeenBought: toRef(form, 'hasBeenBought'),
    });
</script>
    
    <template>
        <Head title="Add Item" />
    
        <component :is="component">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create new Item
                </h2>
            </template>
    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-[#F3FAFC] border-b text-[#353535] text-lg">
                            <form @submit.prevent="submit()">
                                <label for="item-name">Name:</label>
                                <input type="text" name="item-name" class="mt-1 block w-full" v-model="form.name" @blur="v$.name.$touch()"/><br />
                                <div v-if="v$.name.$errors" v-for="error of v$.name.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="item-description">Description:</label>
                                <input type="text" name="item-description" v-model="form.description" class="mt-1 block w-full" @blur="v$.description.$touch()"/><br />
                                <div v-if="v$.description.$errors" v-for="error of v$.description.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="item-price">Price:</label>
                                <input type="text" v-model="form.price" name="item-price" class="mt-1 block w-full" @blur="v$.price.$touch()"/><br />
                                <div v-if="v$.price.$errors" v-for="error of v$.price.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="item-link">Link:</label>
                                <input type="text" name="item-link" v-model="form.link" class="mt-1 block w-full" @blur="v$.link.$touch()"/><br />
                                <div v-if="v$.link.$errors" v-for="error of v$.link.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>

                                <label for="lists" class="block mb-2 text-sm font-medium text-dark-900 dark:text-dark-400">Select a list</label>
                                <select id="lists" class="bg-white-50 border border-white-300 text-dark-900 text-sm focus:ring-white-500 focus:border-white-500 block w-full p-2.5 dark:bg-dark-700 dark:border-dark-600 dark:placeholder-dark-400 dark:text-dark dark:focus:ring-white-500 dark:focus:border-white-500" v-model="form.lists">
                                    <option class="selected">Choose a list</option>
                                    <option v-for="list in lists" :value="list.id">{{list.name}}</option>
                                </select><br />
                                
                                <label class="block mb-2 text-sm font-medium text-dark-900 dark:text-dark-400" for="file_input">Upload image</label>
                                <input class="block w-full text-md text-dark-900 border rounded-md cursor-pointer bg-gray-50 dark:text-dark-300 focus:outline-none dark:bg-gray-300 " aria-describedby="file_input_help" id="file_input" type="file" v-on:change="form.image= $event.target.files[0]" @blur="v$.img.$touch()">
                                <p class="mt-1 text-sm text-dark-500 dark:text-dark-300" id="file_input_help">PNG, JPG (MAX. 2MB).</p>

                                <div v-if="v$.img.$errors" v-for="error of v$.img.$errors" :key="error.$uid" class="text-red-600 font-bold">{{ error.$message}}</div>

                                <br />
                                <label for="item-hasBeenBought" >Has been bought:</label><br />
                                <input class="form-check-input appearance-none h-8 w-8 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-center mr-2 cursor-pointer" type="checkbox" value="1" id="flexCheckDefault" v-model="form.hasBeenBought" @blur="v$.hasBeenBought.$touch()"><br /><br />
                                <div v-if="v$.hasBeenBought.$errors" v-for="error of v$.hasBeenBought.$errors" :key="error.$uid" class="text-[#FF3B3F] font-bold">{{ error.$message}}</div>
                                <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-1">Insert Item</button>
                            </form>
                        </div>
                    </div>
                    <br />
                </div>
            </div>
        </component>
</template>