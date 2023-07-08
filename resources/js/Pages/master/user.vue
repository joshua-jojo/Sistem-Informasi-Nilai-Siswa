<script>
import Textarea_normal from "../../component/input/textarea_normal.vue";
import Select_normal from "../../component/input/select_normal.vue";
import Input_normal from "../../component/input/input_normal.vue";
import Modal_normal from "../../component/modal/modal_normal.vue";
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
export default {
    layout: menu_layout,
    components: {
        Modal_normal,
        Input_normal,
        Textarea_normal,
        Select_normal,
    },
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "User";
    },
};
</script>

<template>
    <div class="w-full flex flex-col gap-4">
        <div class="flex justify-between">
            <label for="test" class="btn bg-success btn-xs">
                <i class="fa fa-plus"></i>
                Tambah
            </label>
            <div class="flex gap-4">
                <div class="join">
                    <div>
                        <div>
                            <input
                                class="input input-bordered input-xs join-item"
                                placeholder="Search..."
                            />
                        </div>
                    </div>
                    <div class="indicator">
                        <button class="btn btn-xs join-item">Search</button>
                    </div>
                </div>
                <div class="flex gap-2 justify-center items-center">
                    <div class="text-sm">Tampilkan :</div>
                    <select class="select select-xs select-bordered">
                        <option value="5">5 baris</option>
                        <option value="10">10 baris</option>
                        <option value="20">20 baris</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto w-full">
            <table class="table table-xs w-full table-zebra">
                <thead class="bg-sky-200">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in 5" :key="index">
                        <th>1</th>
                        <td>Cy Ganderton</td>
                        <td>Quality Control Specialist</td>
                        <td>Littel, Schaden and Vandervort</td>
                        <td>Canada</td>
                        <td>12/16/2020</td>
                        <td class="flex justify-center items-center gap-2">
                            <label class="btn btn-xs bg-warning">
                                <i class="fa fa-pen"></i>
                                edit
                            </label>
                            <label class="btn btn-xs bg-danger">
                                <i class="fa fa-trash"></i>
                                hapus
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center items-center">
            <div class="join">
                <button class="join-item btn btn-xs">1</button>
                <button class="join-item btn btn-xs bg-active">2</button>
                <button class="join-item btn btn-xs">3</button>
                <button class="join-item btn btn-xs">4</button>
            </div>
        </div>
    </div>

    <Modal_normal id="test" title="Tambah User">
        <div class="grid grid-cols-2 gap-4">
            <Input_normal title="Nama" placeholder="Masukkan Nama" />
            <Input_normal title="Username" placeholder="Masukkan Username" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <Input_normal title="Nomor Handphone" placeholder="Masukkan Nomor Handphone" />
            <Select_normal title="Status" placeholder="Masukkan Status" />
        </div>
        <Textarea_normal title="Alamat" placeholder="Masukkan Alamat" />

        <template v-slot:action>
            <button class="btn bg-success">simpan</button>
        </template>
    </Modal_normal>
</template>
