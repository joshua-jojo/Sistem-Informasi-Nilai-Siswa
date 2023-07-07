<template>
    <div class="flex justify-center items-center h-full">
        <button @click="welcome" class="btn btn-success">enjoy</button>
    </div>
</template>
<script>
import Layout_page from "../layout/layout_page.vue";
import { Link } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'
export default {
    layout: Layout_page,
    components: {
        Link,
    },
    methods: {
        welcome: () => {
            router.get(route('welcome'))
        },
    },
};
</script>
