<script>
import menu_layout from '../../layout/menu_layout.vue';
import {useStore} from "vuex"
export default {
    layout : menu_layout,
    setup(){
        const store = useStore()
        store.state.page.bagian = "Pengaturan"
        store.state.page.judul = "Profil Sekolah"
    }
}
</script>

<template>
    <div>
        Profil Sekolah
    </div>
</template>