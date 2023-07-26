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
                    <th>Tanggal</th>
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
                        <td>{{item.user?.guru?.nip}}</td>
                        <td>{{item?.user?.nama}}</td>
                        <td>{{item?.kelas?.kelas}}</td>
                        <td>{{item?.mata_pelajaran?.pelajaran}}</td>
                        <td>{{format_tanggal(new Date(item.tanggal))}}</td>
                        <td>{{item.mulai}}</td>
                        <td>{{item.selesai}}</td>
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

        <div
            class="flex justify-center items-center"
            v-if="jadwal_pelajaran?.data.length"
        >
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

    <!-- tambah  -->
    <modal_lg id="tambah" title="Tambah Jadwal">
        <div class="grid grid-cols-2 gap-4 h-full">
            <div class="card shadow-lg h-full">
                <div class="card-body gap-4 h-full">
                    <Select_normal
                        title="Guru"
                        label="nama"
                        get="id"
                        :data="guru"
                        placeholder="Pilih Guru"
                        v-model="form_tambah.guru_id"
                        :error="form_tambah.errors.guru_id"
                    />
                    <div
                        class="grid grid-cols-2 gap-2 w-full"
                        v-if="form_tambah.guru_id"
                    >
                        <div class="form-control w-full col-span-2">
                            <label class="label">
                                <span class="label-text">Tanggal & Waktu</span>
                            </label>
                            <input
                                type="date"
                                class="input input-bordered input-sm"
                                v-model="jadwal.tanggal"
                            />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Mulai</span>
                            </label>
                            <input
                                type="time"
                                class="input input-bordered input-sm"
                                v-model="jadwal.mulai"
                            />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">selesai</span>
                            </label>
                            <input
                                type="time"
                                class="input input-bordered input-sm"
                                v-model="jadwal.selesai"
                            />
                        </div>
                        <Select_normal
                            title="Kelas"
                            label="kelas"
                            get="id"
                            :data="kelas"
                            placeholder="Pilih Kelas"
                            v-model="jadwal.kelas_id"
                        />
                        <Select_normal
                            title="Pelajaran"
                            label="pelajaran"
                            get="id"
                            :data="mata_pelajaran"
                            placeholder="Pilih Pelajaran"
                            v-model="jadwal.mata_pelajaran_id"
                        />
                    </div>
                    <div
                            class="label col-span-2 "
                            v-if="form_tambah.errors.jadwal"
                        >
                            <span class="label-text-alt text-error">
                                {{ form_tambah.errors.jadwal }}
                            </span>
                        </div>
                    <button
                        class="btn btn-primary"
                        @click="tambah_jadwal"
                        :disabled="cek_jadwal"
                        v-if="form_tambah.guru_id"
                    >
                        Tambah Jadwal
                    </button>
                </div>
            </div>
            <div class="overflow-y-auto max-h-[25rem] py-4 px-4">
                <div class="grid grid-cols-1 gap-4 h-max">
                    <div
                        class="card shadow-lg"
                        v-for="(item, index) in form_tambah.jadwal"
                        :key="index"
                    >
                        <div class="card-body gap-2">
                            <div class="label" v-if="form_tambah.errors?.[`jadwal${item.tanggal}${item.mulai}${item.selesai}`]">
                                <span class="label-text-alt text-error">{{form_tambah?.errors?.[`jadwal${item.tanggal}${item.mulai}${item.selesai}`]}}</span>
                            </div>
                            <table class="table table-xs">
                                <tbody>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>
                                            :
                                            {{
                                                format_tanggal(
                                                    new Date(item.tanggal)
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td class="capitalize">
                                            : {{ nama_kelas(item.kelas_id) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pelajaran</td>
                                        <td class="capitalize">
                                            :
                                            {{
                                                nama_pelajaran(
                                                    item.mata_pelajaran_id
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mulai</td>
                                        <td class="capitalize">
                                            :
                                            {{ item.mulai }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Selesai</td>
                                        <td class="capitalize">
                                            :
                                            {{ item.selesai }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="flex justify-end">
                                <button
                                    class="btn btn-xs btn-error"
                                    @click="hapus_list_jadwal(index)"
                                >
                                    hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template v-slot:action>
            <button
                class="btn bg-success"
                @click="submit_tambah"
                :disabled="form_tambah.processing"
            >
                <span class="loading" v-if="form_tambah.processing"></span>
                tambah
            </button>
        </template>
    </modal_lg>

    <modal_normal id="hapus" title="Hapus Jadwal Pelajaran">
        Lanjutkan untuk menghapus Jadwal Pelajaran. Data yang terkait akan di hapus.
        <template v-slot:action>
            <button @click="submit_hapus" class="btn bg-error" :disabled="form_hapus.processing">
                <span class="loading" v-if="form_hapus.processing"></span>
                Lanjutkan
            </button>
        </template>
    </modal_normal>
</template>
<script>
import { useStore } from "vuex";
import menu_layout from "../../layout/menu_layout.vue";
import { useForm, router, Link } from "@inertiajs/vue3";
import modal_normal from "../../component/modal/modal_normal.vue";
import modal_lg from "../../component/modal/modal_lg.vue";
import Select_normal from "../../component/input/select_normal.vue";
import moment from "moment";
export default {
    layout: menu_layout,
    components: {
        Link,
        modal_normal,
        modal_lg,
        Select_normal,
    },
    props: ["params", "jadwal_pelajaran", "guru", "kelas", "mata_pelajaran"],
    setup() {
        moment.locale(null);
        const store = useStore();
        store.state.page.bagian = "Master";
        store.state.page.judul = "Jadwal Pelajaran";

        const form_tambah = useForm({
            guru_id: null,
            jadwal: [],
        });

        const form_hapus = useForm({
            id: null,
        });
        return {
            form_tambah,
            form_hapus,
            moment,
        };
    },
    data() {
        return {
            show: this.params.show,
            cari: this.params.cari,
            jadwal: {
                tanggal: "",
                mulai: "",
                selesai: "",
                kelas_id: "",
                mata_pelajaran_id: "",
            },
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
        async tambah_jadwal() {
            this.form_tambah.jadwal.push({ ...this.jadwal });
            this.jadwal.tanggal = "";
            this.jadwal.mulai = "";
            this.jadwal.selesai = "";
            this.jadwal.kelas_id = "";
            this.jadwal.mata_pelajaran_id = "";
        },
        format_tanggal(data) {
            return new Intl.DateTimeFormat("id-ID", {
                dateStyle: "full",
                timeZone: "Asia/Jakarta",
            }).format(data);
        },
        nama_kelas(data) {
            return this.kelas.find((item) => item.id == data)?.kelas;
        },
        nama_pelajaran(data) {
            return this.mata_pelajaran.find((item) => item.id == data)
                ?.pelajaran;
        },
        async hapus_list_jadwal(data) {
            const data_list = await this.form_tambah.jadwal.filter(
                (item, index) => index != data
            );
            this.form_tambah.jadwal = data_list;
        },
        submit_tambah() {
            this.form_tambah.post(route("master.jadwal-pelajaran.store"), {
                onSuccess: () => {
                    document.getElementById("tambah")?.click();
                    this.form_tambah.reset()
                },
            });
        },
        data_hapus(data){
            this.form_hapus.id = data.id
        },
        submit_hapus(){
            this.form_hapus.delete(route("master.jadwal-pelajaran.destroy",{id : this.form_hapus.id}),{
                onSuccess : () => {
                    document.getElementById("hapus").click()
                    this.form_hapus.reset()
                }
            })
        }
    },
    computed: {
        cek_jadwal() {
            return !(
                this.jadwal.tanggal &&
                this.jadwal.mulai &&
                this.jadwal.selesai &&
                this.jadwal.kelas_id &&
                this.jadwal.mata_pelajaran_id
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
<style lang=""></style>
