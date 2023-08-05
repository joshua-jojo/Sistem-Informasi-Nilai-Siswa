<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    setup() {
        const store = useStore();
        store.state.page.bagian = "Dashboard";
        store.state.page.judul = "Halaman Utama";
    },
    props :["jurusan","kelas","pelajaran","murid","guru","user","user_auth"]
};
</script>

<template>
    <div class="alert mb-2 shadow-lg">
        <div class="">
            Selamat Datang <b>{{user_auth?.nama}}</b>.
        </div>
    </div>

    <div class="grid grid-cols-3 gap-8" v-if="user_auth?.role_id == 2 || user_auth?.role_id == 1">
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">Jurusan</div>
                <div class="stat-value">{{jurusan}} Jurusan</div>
            </div>
        </div>
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">Kelas</div>
                <div class="stat-value">{{kelas}} Kelas</div>
            </div>
        </div>
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">Mata Pelajaran</div>
                <div class="stat-value">{{pelajaran}} Pelajaran</div>
            </div>
        </div>
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">Murid</div>
                <div class="stat-value">{{murid}} Murid</div>
            </div>
        </div>
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">Kepala Sekolah / Guru</div>
                <div class="stat-value">{{guru}} User</div>
            </div>
        </div>
        <div class="stats shadow-md hover:scale-110 transition-all ease-in-out duration-300">
            <div class="stat place-items-center">
                <div class="stat-title">User</div>
                <div class="stat-value">{{user}} User</div>
            </div>
        </div>
    </div>
</template>
