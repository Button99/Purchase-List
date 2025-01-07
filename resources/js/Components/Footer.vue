<script setup>
import { Link } from '@inertiajs/inertia-vue3';

</script>
<template>
    <footer class="sticky top-[90vh]">
        <hr class="my-6 border-[1px] sm:mx-auto border-[#666666]  lg:my-8" />
        <span class="block text-sm sm:text-center text-center text-[#666666]">
            © 2023 PurchaseList. All Rights Reserved. <br /> <Link :href="route('changelog')"> @v1.0.0 </Link>
        </span>
        <a href="https://www.buymeacoffee.com/purchaselist" target="_blank" class="place-content-center	content-center object-center justify-center max-w-screen flex"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" class=" object-center justify-center" style="height: 50px !important; width: 170px !important; " ></a>
    </footer>
</template>
