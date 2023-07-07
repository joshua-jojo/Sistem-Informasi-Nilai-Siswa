<script>
import menu_layout from '../../layout/menu_layout.vue';
import {useStore} from "vuex"
export default {
    layout : menu_layout,
    setup(){
        const store = useStore()
        store.state.page.bagian = "Pengaturan"
        store.state.page.judul = "Profil User"
    }
}
</script>

<template>
    <div>
        profil user
    </div>
</template>