<script>
import { router } from "@inertiajs/vue3";
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    props: ["params", "nilai_akademik"],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Laporan";
        store.state.page.judul = "Nilai Akademik";
    },
    data() {
        return {
            show: this.params.show,
            cari: this.params.cari,
        };
    },
    methods: {
        get_data() {
            const params = {
                show: this.show,
                cari: this.cari,
            };
            router.get(route("laporan.nilai-akademik.index"), params, {
                preserveState: true,
            });
        },
    },
    watch: {
        show() {
            this.get_data();
        },
        cari() {
            this.get_data();
        },
    },
};
</script>

<template>
    <div class="flex flex-col gap-2">
        <div class="flex justify-between">
            <div class="flex gap-4">
                <div class="form-control">
                    <input
                        type="text"
                        class="input input-xs input-bordered"
                        placeholder="Search..."
                        v-model="cari"
                    />
                </div>
            </div>
            <div class="flex gap-2 justify-center items-center">
                    <div class="text-sm">Tampilkan</div>
                    <select
                        class="select select-bordered select-xs"
                        v-model="show"
                    >
                        <option :value="5">5 baris</option>
                        <option :value="10">10 baris</option>
                        <option :value="20">20 baris</option>
                    </select>
                </div>
        </div>

        <!-- tabel  -->
        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="bg-sky-200">
                        <th>NO.</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in nilai_akademik?.data"
                            :key="item?.id"
                            v-if="nilai_akademik?.data?.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td class="capitalize">{{ item.murid?.nama }}</td>
                            <td class="capitalize">{{ item.murid?.murid?.kelas.kelas }}</td>
                            <td class="capitalize">{{ item.tugas_ulangan?.jadwal_pelajaran?.tanggal }}</td>
                            <td>{{item.nilai}}</td>
                        </tr>
                        <tr v-else>
                            <td colspan="10" class="text-center font-bold">
                                Belum ada data!
                            </td>
                        </tr>
                    </transition-group>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center" v-if="nilai_akademik?.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in nilai_akademik?.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url ? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>
</template>
