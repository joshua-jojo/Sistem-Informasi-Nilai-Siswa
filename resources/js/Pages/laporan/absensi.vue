<script>
import menu_layout from '../../layout/menu_layout.vue';
import {useStore} from "vuex"
export default {
    layout : menu_layout,
    setup(){
        const store = useStore()
        store.state.page.bagian = "Laporan"
        store.state.page.judul = "Absensi"
    }
}
</script>

<template>
    <div>
        Dashboard
    </div>
</template>