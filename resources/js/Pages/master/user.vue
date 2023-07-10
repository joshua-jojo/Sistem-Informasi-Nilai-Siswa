<script>
import Textarea_normal from "../../component/input/textarea_normal.vue";
import Select_normal from "../../component/input/select_normal.vue";
import Input_normal from "../../component/input/input_normal.vue";
import Input_password from "../../component/input/input_password.vue";
import Modal_normal from "../../component/modal/modal_normal.vue";
import menu_layout from "../../layout/menu_layout.vue";
import { useStore } from "vuex";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'

export default {
    layout: menu_layout,
    props: ["role", "user"],
    components: {
        Modal_normal,
        Input_normal,
        Textarea_normal,
        Select_normal,
        Input_password,
        Link
    },
    setup() {
        const store = useStore();
        const form_tambah = useForm({
            nama: "",
            username: "",
            password: "",
            password_confirmation: "",
            no_hp: "",
            status: "",
            alamat: "",
            role_id: null,
        });

        const form_hapus = useForm({
            id: null,
            nama: null,
        });

        store.state.page.bagian = "Master";
        store.state.page.judul = "User";

        return {
            form_tambah,
            form_hapus,
        };
    },
    data(){
        return {
            show : 5,
            cari : "",
        }
    },
    watch : {
        "show"(){
            this.get_data()
        },
        "cari"(){
            this.get_data()
        },
    },
    methods: {
        submit_tambah() {
            this.form_tambah.post(route("master.user.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
        get_data(){
            const params = {
                search: this.cari,
                show : this.show,
            };
            router.get(route("master.user.index"), params, {
                preserveState: true,
            });
        },
        get_hapus_data(item) {
            this.form_hapus.id = item.id;
            this.form_hapus.nama = item.nama;
            console.log(item);
        },
        hapus_user() {
            this.form_hapus.delete(
                route("master.user.destroy", {
                    user: this.form_hapus.id,
                }),
                {
                    onSuccess: () => {
                        document.getElementById("hapus")?.click();
                        this.form_hapus.reset();
                    },
                }
            );
        },
    },
};
</script>

<template>
    <div class="w-full flex flex-col gap-4 scrollbar-hide">
        <div class="flex justify-between">
            <label for="tambah" class="btn bg-success btn-xs">
                <i class="fa fa-plus"></i>
                Tambah
            </label>
            <div class="flex gap-4">
                <input
                    class="input input-bordered input-xs join-item"
                    placeholder="Search..."
                    v-model="cari"
                />
                <div class="flex gap-2 justify-center items-center">
                    <div class="text-sm">Tampilkan :</div>
                    <select class="select select-xs select-bordered" v-model="show">
                        <option :value="5">5 baris</option>
                        <option :value="10">10 baris</option>
                        <option :value="20">20 baris</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto w-full scrollbar-hide">
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
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in user.data"
                            :key="item.id"
                            v-if="user.data.length"
                        >
                            <th>{{ index + 1 }}</th>
                            <td class="capitalize">{{ item.nama }}</td>
                            <td>{{ item.username }}</td>
                            <td class="capitalize font-bold">
                                {{ item.status }}
                            </td>
                            <td class="capitalize">{{ item.alamat }}</td>
                            <td>{{ item.no_hp }}</td>
                            <td class="flex justify-center items-center gap-2">
                                <label class="btn btn-xs bg-warning">
                                    <i class="fa fa-pen"></i>
                                    edit
                                </label>
                                <label
                                    class="btn btn-xs bg-danger"
                                    for="hapus"
                                    @click="get_hapus_data(item)"
                                >
                                    <i class="fa fa-trash"></i>
                                    hapus
                                </label>
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
        <div class="flex justify-center items-center" v-if="user.data.length">
            <div class="join">
                <Link as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in user.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>

    <Modal_normal id="tambah" title="Tambah User">
        <div class="grid grid-cols-2 gap-4">
            <Input_normal
                v-model="form_tambah.nama"
                :error="form_tambah.errors.nama"
                :length="100"
                title="Nama"
                placeholder="Masukkan Nama"
            />
            <Input_normal
                v-model="form_tambah.username"
                :error="form_tambah.errors.username"
                :length="100"
                title="Username"
                placeholder="Masukkan Username"
            />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <Input_normal
                v-model="form_tambah.no_hp"
                :error="form_tambah.errors.no_hp"
                :length="15"
                autocomplete="off"
                title="Nomor Handphone"
                placeholder="Masukkan Nomor Handphone"
            />
            <Select_normal
                v-model="form_tambah.role_id"
                :key="form_tambah.role_id"
                :error="form_tambah.errors.role_id"
                label="nama"
                get="id"
                :data="role"
                title="Status"
                placeholder="Pilih Status"
            />
        </div>
        <Textarea_normal
            v-model="form_tambah.alamat"
            :error="form_tambah.errors.alamat"
            :length="100"
            title="Alamat"
            placeholder="Masukkan Alamat"
        />
        <div class="grid grid-cols-2 gap-4">
            <Input_password
                v-model="form_tambah.password"
                :error="form_tambah.errors.password"
                :length="100"
                title="Password"
                placeholder="Masukkan Nama"
            />
            <Input_password
                v-model="form_tambah.password_confirmation"
                :length="100"
                title="Konfirmasi Password"
                placeholder="Masukkan Username"
            />
        </div>

        <template v-slot:action>
            <button
                class="btn bg-success"
                :class="{ 'loading btn-disabled': form_tambah.processing }"
                @click="submit_tambah"
            >
                simpan
            </button>
        </template>
    </Modal_normal>

    <Modal_normal id="hapus" :title="'Hapus Pengguna ' + form_hapus.nama">
        Perhatian untuk menghapus pengguna <b>{{ form_hapus.nama }}</b
        >. Semua data yang terkait akan di hapus dari sistem. Tetap lanjutkan?
        <template v-slot:action>
            <button
                class="btn bg-danger"
                :class="{ 'loading btn-disabled': form_hapus.processing }"
                @click="hapus_user"
            >
                Lanjutkan
            </button>
        </template>
    </Modal_normal>
</template>
