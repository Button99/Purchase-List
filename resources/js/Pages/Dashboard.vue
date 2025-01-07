<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Doughnut } from 'vue-chartjs';
    import {Chart as ChartJS, ArcElement, Tooltip, Legend} from 'chart.js';
    import { reactive, ref } from 'vue';

    ChartJS.register(ArcElement, Tooltip, Legend);

    const props= defineProps(['user']);
    let items= reactive(ref(0));
    let lists= reactive(ref(0));
    let isAdmin= false;
    let component= reactive(AuthenticatedLayout);
    
    axios.get('/isAdmin')
        .then((res) => {
            isAdmin= res.data;
            if(isAdmin === 1) {
                component.value= AdminLayout;
            } else {
                component.value= AuthenticatedLayout;
            }
        }).catch((err) => {
            console.log(err);
    });
    axios.get('/itemList/getTotalLists')
        .then((res) => {
            items.value= res.data.itemsNum;
            lists.value= res.data.listsNum;
        }).catch((err) => {
            console.log(err.data);
        });

        const chartData= (items, lists) => {
            var labels= ['Items', 'Lists'];
            var datasets= [{
                data: [items, lists],
                backgroundColor: ['#909090', '#DB7777']
            }];
            return {labels, datasets};
        }

        const chartOptions= () => {
            var responsive= true;
            var maintainAspectRatio= false;
            var aspectRation= 1;
            return {responsive, maintainAspectRatio, aspectRation};
        }
</script>

<template>
    <Head title="Dashboard" />

    <component :is="component.value">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-[#e2e9e9] border-b text-[#353535] text-lg">
                        Welcome {{user}}! Before creating an item, please create a new list if this is your first time logging in.
                    </div>
                </div>
                <br />
                <div class="mx-auto px-auto max-w-xl sm:px-6 lg:px-7 sm:flex-row flex flex-nowrap">
                    <Link :href="route('addItem')" class="text-sm space-x-0.5">
                        <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-2 m-6 flex shrink-0">Insert Item</button>
                    </Link>
                    <Link :href="route('showLists')" class="text-sm text-gray-700 dark:text-gray-500 space-x-0.5">
                        <button class="rounded hover:rounded-md bg-[#98777B] text-white text-lg font-bold p-2 m-6 object-center flex-none shrink-0 ">Show Lists</button>
                    </Link>
                    <Link :href="route('addList')" class="text-sm text-gray-700 dark:text-gray-500 space-x-0.5">
                        <button class="rounded hover:rounded-lg bg-[#98777B] text-white text-lg font-bold p-2 m-6 object-right float-right shrink-0">Create a List</button>
                    </Link>
                </div><br/><br/><br/>
            </div>
            <div class="w-100 h-80 align-items-center">
                <div class="border-dotted font-bold border-2 border-[#A9A9A9]">
                    <h1 class="text-3xl text-center m-2 xl:border-dashed b-2">Statistics</h1>
                </div><br />
                <div class="max-h-[32vh]">
                    <Doughnut :data="chartData(items, lists)" :options="chartOptions()" class="align-items-center"/><br/>
                </div>
            </div>
        </div>
    </component>
</template>