<script setup>
import { ref,defineEmits,watch } from "vue";
const props = defineProps({
    placeholder: String,
    name: String,
    error: String,
    title: String,
    label: String,
    modelValue: Number,
    get: String,
    data: Array,
    uppercase: Boolean,
});

const emit = defineEmits(['update:modelValue'])
</script>
<template lang="">
    <div class="form-control">
        <label class="label">
            <span class="label-text">{{ props.title }}</span>
        </label>
        <select
            :name="props.name"
            :value="props.modelValue"
            @change="emit('update:modelValue',$event.target.value)"
            class="select select-sm select-bordered w-full"
            :class="{'uppercase' : props.uppercase, 'capitalize' : !props.uppercase}"
        >
        <option disabled selected value="">{{props.placeholder}}</option>
            <option
                :value="item[props.get]"
                v-for="(item, index) in props.data"
                :key="index"
                :class="{'uppercase' : props.uppercase}"
            >
                {{ item[props.label] }}
            </option>
        </select>
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{ props.error }}</span>
        </label>
    </div>
</template>
