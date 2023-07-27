<template lang="">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between gap-4">
            <div class="flex flex-row w-max justify-center items-center gap-2">
                <label class="label">
                    <span class="label-text">Tampilkan data tanggal : </span>
                </label>
                <input
                    type="date"
                    v-model="dari"
                    class="input input-bordered input-sm"
                />
                <label class="label">
                    <span class="label-text">Sampai tanggal : </span>
                </label>
                <input
                    type="date"
                    v-model="sampai"
                    class="input input-bordered input-sm"
                />
            </div>
        </div>

        <!-- tabel  -->
        <table class="table table-xs w-full table-zebra select-none">
            <thead>
                <tr class="bg-sky-200">
                    <th>No.</th>
                    <th>Kelas</th>
                    <th>Pelajaran</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th class="text-center">Menu</th>
                </tr>
            </thead>
            <tbody>
                <transition-group name="table" v-if="jadwal_mengajar.length">
                    <tr v-for="(item, index) in jadwal_mengajar" :key="item.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{item?.kelas?.kelas}}</td>
                        <td>{{item?.mata_pelajaran.pelajaran}}</td>
                        <td>{{item.mulai}}</td>
                        <td>{{item.selesai}}</td>
                        <td class="flex justify-center gap-2">
                            <label for="tambah nilai" class="btn btn-xs btn-success">
                                tambah nilai
                            </label>

                            <label for="absensi" class="btn btn-xs btn-primary">
                                Absensi
                            </label>
                        </td>
                    </tr>
                </transition-group>
                <tr v-else>
                    <td colspan="99" class="text-center font-bold capitalize">
                        Belum Ada Jadwal
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { useStore } from "vuex";
import Menu_layout from "../../layout/menu_layout.vue";
import { router } from "@inertiajs/vue3";

export default {
    layout: Menu_layout,
    props: ["params", "jadwal_mengajar"],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Data";
        store.state.page.judul = "Jadwal Mengajar";
    },
    data() {
        return {
            dari: this.params.dari,
            sampai: this.params.sampai,
        };
    },
    methods: {
        get_data() {
            router.get(
                route("laporan.jadwal-mengajar.index"),
                {
                    dari: this.dari,
                    sampai: this.sampai,
                },
                {
                    preserveState: true,
                }
            );
        },
    },
    watch: {
        dari() {
            this.get_data();
        },
        sampai() {
            this.get_data();
        },
    },
};
</script>
<style lang=""></style>
