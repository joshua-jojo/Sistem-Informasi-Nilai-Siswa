<script>
import menu_layout from '../../layout/menu_layout.vue';
import {useStore} from "vuex"
export default {
    layout : menu_layout,
    setup(){
        const store = useStore()
        store.state.page.bagian = "Master"
        store.state.page.judul = "Mata Pelajaran"
        return {
            store
        }
    }
}
</script>

<template>
    <div>
       {{  store.state.page.judul }}
    </div>
</template>