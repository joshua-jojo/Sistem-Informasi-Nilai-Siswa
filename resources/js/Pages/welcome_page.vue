<template>
    <div class="flex justify-center items-center h-full">
        <Link :href="route('enjoy')" class="btn btn-success w-max">welcome</Link>
    </div>
</template>
<script>
import Layout_page from "./layout_page.vue";
import {Link} from '@inertiajs/vue3'
export default {
    layout: Layout_page,
    components : {
        Link
    }
};
</script>
