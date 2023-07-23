<script>
import menu_layout from "../../layout/menu_layout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import { useStore } from "vuex";
import modal_normal from "../../component/modal/modal_normal.vue";
import input_normal from "../../component/input/input_normal.vue";
import Textarea_normal from "../../component/input/textarea_normal.vue";
import Input_password from "../../component/input/input_password.vue";

export default {
    layout: menu_layout,
    setup() {
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Guru";

        const form_tambah = useForm({
            nama: "",
            username: "",
            password: "",
            password_confirmation: "",
            alamat: "",
            no_hp: "",
        });
        const form_edit = useForm({
            id: null,
            nama: "",
            username: "",
            password: "",
            password_confirmation: "",
            alamat: "",
            no_hp: "",
        });
        return {
            form_tambah,
            form_edit,
        };
    },
    props: ["params", "guru", "mata_pelajaran"],
    components: {
        Link,
        modal_normal,
        input_normal,
        Textarea_normal,
        Input_password,
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
            router.get(route("master.guru.index"), params, {
                preserveState: true,
            });
        },
        submit_tambah() {
            this.form_tambah.post(route("master.guru.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset();
                },
            });
        },
        data_edit(data) {
            this.form_edit.id = data.id;
            this.form_edit.nama = data.nama;
            this.form_edit.username = data.username;
            this.form_edit.alamat = data.alamat;
            this.form_edit.no_hp = data.no_hp;
        },
        submit_edit() {
            this.form_edit.put(
                route("master.guru.update", {
                    id: this.form_edit.id,
                }),
                {
                    onSuccess: () => {
                        document.getElementById("edit")?.click();
                        this.form_edit.reset();
                    },
                }
            );
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
        <div class="overflow-x-auto scrollbar-hide">
            <table class="table table-xs table-zebra">
                <thead>
                    <tr class="bg-sky-200">
                        <th>NO.</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <transition-group name="table">
                        <tr
                            v-for="(item, index) in guru?.data"
                            :key="item?.id"
                            v-if="guru?.data?.length"
                        >
                            <td>{{ index + 1 }}</td>
                            <td class="w-[6rem]">
                                <div
                                    class="badge badge-error badge-sm"
                                    v-if="!item.guru?.nip"
                                >
                                    Belum Ada
                                </div>
                                <div class="" v-else>
                                    {{ item.guru?.nip }}
                                </div>
                            </td>
                            <td>{{ item.nama }}</td>
                            <td>{{ item.no_hp }}</td>
                            <td>{{ item.alamat }}</td>
                            <td class="w-48">
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
        </div>

        <div class="flex justify-center items-center" v-if="guru?.data.length">
            <div class="join">
                <Link
                    as="button"
                    class="join-item btn btn-xs"
                    :class="{ 'bg-active': item.active }"
                    v-for="(item, index) in guru?.links"
                    :key="index"
                    v-html="item.label"
                    :disabled="!item.url"
                    :href="item.url ? item.url : '#'"
                    :preserve-state="true"
                ></Link>
            </div>
        </div>
    </div>

    <!-- tambah  -->
    <modal_normal id="tambah" title="Tambah Guru">
        <div class="grid grid-cols-2 gap-2">
            <input_normal
                v-model="form_tambah.nama"
                :error="form_tambah.errors.nama"
                :length="100"
                title="Nama"
                placeholder="Masukkan Nama"
            />
            <input_normal
                v-model="form_tambah.username"
                :error="form_tambah.errors.username"
                :length="100"
                title="Username"
                placeholder="Masukkan Username"
            />
        </div>
        <input_normal
            v-model="form_tambah.no_hp"
            :error="form_tambah.errors.no_hp"
            :length="100"
            title="No Handphone"
            placeholder="Masukkan No Handphone"
        />
        <Textarea_normal
            v-model="form_tambah.alamat"
            :error="form_tambah.errors.alamat"
            :length="100"
            title="Alamat"
            placeholder="Masukkan Alamat"
        />
        <div class="grid grid-cols-2 gap-2">
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
                :disabled="form_tambah.processing"
                @click="submit_tambah"
            >
                <span class="loading" v-if="form_tambah.processing"></span>
                tambah
            </button>
        </template>
    </modal_normal>

    <!-- edit  -->
    <modal_normal id="edit" title="Edit Guru">
        <div class="grid grid-cols-2 gap-2">
            <input_normal
                v-model="form_edit.nama"
                :error="form_edit.errors.nama"
                :length="100"
                title="Nama"
                placeholder="Masukkan Nama"
            />
            <input_normal
                v-model="form_edit.username"
                :error="form_edit.errors.username"
                :length="100"
                title="Username"
                placeholder="Masukkan Username"
            />
        </div>
        <input_normal
            v-model="form_edit.no_hp"
            :error="form_edit.errors.no_hp"
            :length="100"
            title="No Handphone"
            placeholder="Masukkan No Handphone"
        />
        <Textarea_normal
            v-model="form_edit.alamat"
            :error="form_edit.errors.alamat"
            :length="100"
            title="Alamat"
            placeholder="Masukkan Alamat"
        />
        <div class="grid grid-cols-2 gap-2">
            <Input_password
                v-model="form_edit.password"
                :error="form_edit.errors.password"
                :length="100"
                title="Password"
                placeholder="Masukkan Nama"
            />
            <Input_password
                v-model="form_edit.password_confirmation"
                :length="100"
                title="Konfirmasi Password"
                placeholder="Masukkan Username"
            />
        </div>

        <template v-slot:action>
            <button
                class="btn bg-warning"
                :disabled="form_edit.processing"
                @click="submit_edit"
            >
                <span class="loading" v-if="form_edit.processing"></span>
                edit
            </button>
        </template>
    </modal_normal>
</template>
