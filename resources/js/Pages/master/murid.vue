<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    props: ["params", "murid"],
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Murid";
    },
    data() {
        return {
            show: this.params.show,
            cari: this.params.cari,
        };
    },
};
</script>

<template>
    <div class="flex flex-col gap-4">
        <div class="flex justify-between">
            <div class="flex gap-4">
                <label for="tambah" class="btn btn-xs bg-success">
                    <i class="fa fa-plus"></i> tambah
                </label>
            </div>

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

        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="capitalize bg-sky-200">
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in murid.data"
                            :key="item.id"
                            v-if="murid.data.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>NIS</td>
                            <td>Nama</td>
                            <td>Alamat</td>
                            <td>Kontak</td>
                            <td class="w-40">
                                <div class="flex gap-2 justify-center">
                                    <label
                                        for="edit"
                                        class="btn btn-xs bg-warning"
                                    >
                                        <i class="fa fa-pen"></i>
                                        edit
                                    </label>
                                    <label
                                        for="hapus"
                                        class="btn btn-xs bg-danger"
                                    >
                                        <i class="fa fa-pen"></i>
                                        hapus
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="7" class="text-center font-bold">
                                Belum ada data!
                            </td>
                        </tr>
                    </transition-group>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center" v-if="murid.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in murid.links"
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
