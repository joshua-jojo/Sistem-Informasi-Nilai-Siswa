<script>
import menu_layout from '../../layout/menu_layout.vue';
import {useStore} from "vuex"
export default {
    layout : menu_layout,
    setup(){
        const store = useStore()
        store.state.page.bagian = "Master"
        store.state.page.judul = "Ekskul"
    }
}
</script>

<template>
    <div>
        Dashboard
    </div>
</template>