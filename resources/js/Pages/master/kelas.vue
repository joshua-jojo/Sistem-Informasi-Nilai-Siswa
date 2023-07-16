<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Kelas";
    },
    data() {
        return {
            cari: "",
            show: 5,
        };
    },
};
</script>

<template>
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

        <!-- table  -->
        <div class="overflow-x-auto">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Kelas</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-sky-200">
                        <td>NO.</td>
                        <td>Kelas</td>
                        <td class="w-40">
                            <div class="flex gap-2 w-full">
                                <label for="edit" class="btn btn-xs bg-warning">
                                    <i class="fa fa-pen"></i> edit
                                </label>
                                <label for="hapus" class="btn btn-xs bg-error">
                                    <i class="fa fa-trash"></i> hapus
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
