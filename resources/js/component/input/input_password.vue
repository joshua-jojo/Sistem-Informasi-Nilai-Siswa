<script setup>
import {defineEmits,ref,watch} from 'vue'
const props = defineProps({
    placeholder : String,
    name : String,
    error : String,
    length : Number,
    title : String,
    modelValue : String,
})

const emit = defineEmits(['update:modelValue'])
</script>
<template lang="">
    <div class="form-control">
        <label class="label">
            <span class="label-text">{{props.title}}</span>
            <span class="label-text-alt text-xs" v-if="props.length"> {{props.modelValue.length}} / {{props.length}}</span>
        </label>
        <input
            type="password"
            :value="props.modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            class="input input-sm input-bordered w-full"
            :placeholder="props.placeholder"
            autocomplete="off"
        />
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{props.error}}</span>
        </label>
    </div>
</template>
