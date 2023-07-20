<template lang="">
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">
                {{ title }}
            </span>
        </label>
        <div class="w-full flex gap-2">
            <input
                type="text"
                class="input input-bordered input-sm w-full"
                :placeholder="placeholder"
                v-model="input_user"
                :disabled="modelValue"
            />
            <button class="btn btn-sm" v-if="modelValue" @click="reset_pick">
                reset
            </button>
        </div>
        <div class="w-full px-4 select-none">
            <table class="table table-zebra table-xs">
                <tbody>
                    <tr
                        :class="{ capitalize: capitalize }"
                        v-for="(item, index) in data_pick"
                        :key="item.id"
                        @click="pick(item)"
                    >
                        <td>{{ item[label] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <label class="label" v-if="error">
            <span class="label-text-alt text-error">
                {{ error }}
            </span>
        </label>
    </div>
</template>
<script>
export default {
    props: [
        "title",
        "placeholder",
        "error",
        "modelValue",
        "data",
        "label",
        "get",
        "capitalize",
    ],
    data() {
        return {
            input_user: "",
        };
    },
    emits: ["update:modelValue"],
    methods: {
        pick(data) {
            this.input_user = data[this.label]
            this.$emit("update:modelValue", data[this.get]);
        },
        reset_pick(data) {
            this.input_user = null
            this.$emit("update:modelValue", null);
        },
    },
    watch : {
        "modelValue"(baru){
            const input_user = this.input_user == null || this.input_user.length == 0
            if(baru > 0 && input_user){
                const data = this.data.find((e) => {
                    return e.id == baru
                })
                this.input_user = data.nama
            }
        }
    },
    computed: {
        data_pick() {
            if (this.modelValue == null) {
                const max = 5;
                let loop = 1;
                const data_input = this.input_user
                return this.data.filter((e) => {
                    if (
                        e[this.label]
                            .toLocaleLowerCase()
                            .includes(data_input? data_input.toLocaleLowerCase() : '')
                    ) {
                        if (loop <= max) {
                            loop++;
                            return e;
                        }
                    }
                });
            }
        },
    },
};
</script>
<style lang=""></style>
