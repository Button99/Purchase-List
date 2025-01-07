<script setup>

defineProps({
    headline: String,
    isOpen: false,
    content: String
});
</script>

<template>
    <div class="border-[10px] border-[#A9A9A9] bg-[#F3FAFC] p-2 mt-2">
        <div v-on:click="isOpen = !isOpen" class="p-4 font-bold rounded cursor-pointer"><span v-html="headline" class="text-[#353535]"></span>
            <svg class="w-6 float-right rotate-180" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" v-if="!isOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>

            <svg class="w-6 float-right" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg" v-if="isOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </div>
        <div class="mt-4 border-[5px] border-[#A9A9A9] p-2" :class="isOpen ? 'd-block' : 'hidden'">
            <p v-html="content" class="text-[#353535]"></p>
        </div>
    </div>
</template>
