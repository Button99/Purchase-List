<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { reactive, ref } from 'vue';
    import {Pie} from 'vue-chartjs';
    import { Chart as ChartJS, Tooltip, Legend, ArcElement} from 'chart.js'

    ChartJS.register(ArcElement, Tooltip, Legend);

    const props= defineProps(['user']);
    let items= reactive(ref([]));
    let listName= reactive(ref(''));
    let bought=reactive(ref(0));
    let notBought=reactive(ref(0));

    axios.get('/getItems/' + route().params.id) 
        .then((res) => {
            items.value= res.data;
            bought= ref(Object.keys(items.value).filter(k => items.value[k].has_been_bought == true));
            notBought= ref(Object.keys(items.value).filter(k => items.value[k].has_been_bought == false));
        }).catch((err) => {
            console.log(err);
        });

    axios.get('/itemList/' + route().params.id + '/getName')
        .then((res) => {
            listName= res.data;
        }).catch((err) => {
            console.log(err);
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

    const chartData= (bought, notBought) => {
        var labels= [ 'Items you have bought', 'Items to buy'];
        var datasets= [{
            data: [bought, notBought],
            backgroundColor: ['#31ADC7', '#FF3B3F']
        }];
        return {labels, datasets};
    }
    
    const chartOptions= () => {
        var responsive= true;
        var maintainAspectRatio= false;
        return {responsive, maintainAspectRatio};
      };
</script>

<template>
    <Head title="Display Items" />

    <component :is="component">
        <template #header>
            <h2 class="font-semibold text-xl text-[#353535] leading-tight">
                Items in List {{listName}}
            </h2>
        </template>
        <div class="py-12 flex block-inline grid md:grid-cols-4 md:gap-4">
            <div class="max-w-sm m-4 rounded bg-[#E2E9E9] overflow-hidden flex" v-for="item in items">
                <div class="md:px-6 md:py-4 sm:px-4 bg-[#E2E9E9]">
                    <Link :href="route('item.data', item.id)"><div class="font-bold text-xl mb-2 px-6 py-4 m-2 text-[#353535]">{{item.name}}</div>
                    <p class="text-[#353535] text-base m-2">
                            Description: {{item.description}}
                    </p></Link>
                    </div>
            </div>
        </div>
        <div class="w-100 h-80 place-content-between align-items-center">
            <Pie id="my-chart-id" :options="chartOptions()" :data="chartData(bought.length, notBought.length)" class="align-items-center"/></div>
    </component>
</template>
