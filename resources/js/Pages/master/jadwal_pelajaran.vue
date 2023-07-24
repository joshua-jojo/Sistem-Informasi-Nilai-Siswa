<template lang="">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <label for="tambah" class="btn btn-xs bg-success">
                <i class="fa fa-plus"></i> tambah
            </label>
            <div class="flex gap-4">
                <div class="form-control">
                    <input
                        type="text"
                        class="input input-xs input-bordered"
                        placeholder="Search..."
                        v-model="cari"
                    />
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
        </div>

        <!-- tabel  -->
        <table class="table table-xs table-zebra">
            <thead>
                <tr class="bg-sky-200">
                    <th>NO.</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <transition-group name="table">
                    <tr
                        v-for="(item, index) in jadwal_pelajaran?.data"
                        :key="item?.id"
                        v-if="jadwal_pelajaran?.data.length"
                    >
                        <td>{{ index + 1 }}</td>
                        <td>NO.</td>
                        <td>NIP</td>
                        <td>Nama Guru</td>
                        <td>Kelas</td>
                        <td>Mata Pelajaran</td>
                        <td>Mulai</td>
                        <td>Selesai</td>
                        <td class="w-40">
                            <div class="flex gap-2 w-full">
                                <label
                                    @click="data_edit(item)"
                                    for="edit"
                                    class="btn btn-xs bg-warning"
                                >
                                    <i class="fa fa-pen"></i> edit
                                </label>
                                <label
                                    @click="data_hapus(item)"
                                    for="hapus"
                                    class="btn btn-xs bg-error"
                                >
                                    <i class="fa fa-trash"></i> hapus
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="10" class="text-center font-bold">
                            Belum ada data!
                        </td>
                    </tr>
                </transition-group>
            </tbody>
        </table>

        <div class="flex justify-center items-center" v-if="jadwal_pelajaran?.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in jadwal_pelajaran?.links"
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
<script>
import { useStore } from "vuex";
import menu_layout from "../../layout/menu_layout.vue";
import { useForm, router,Link } from "@inertiajs/vue3";
export default {
    layout: menu_layout,
    components : {
        Link
    },
    props: ["params", "jadwal_pelajaran"],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Jadwal Pelajaran";

        const form_tambah = useForm({
            guru_id: "",
            jadwal: [],
        });
        return {
            form_tambah,
        };
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
            router.get(route("master.jadwal-pelajaran.index"), params, {
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
<style lang=""></style>
