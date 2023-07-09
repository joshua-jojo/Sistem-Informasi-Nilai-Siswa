<script setup>
import { defineEmits, ref, watch } from "vue";
const props = defineProps({
    placeholder: String,
    name: String,
    error: String,
    title: String,
    modelValue: String,
    length: Number,
});

const emit = defineEmits(["update:modelValue"]);
</script>
<template lang="">
    <div class="form-control">
        <label class="label">
            <span class="label-text">{{ props.title }}</span>
            <span class="label-text-alt text-xs" v-if="props.length"> {{modelValue.length}} / {{props.length}}</span>
        </label>
        <textarea
            :name="props.name"
            type="text"
            :value="modelValue"
            @input="emit('update:modelValue',$event.target.value)"
            class="textarea textarea-sm textarea-bordered w-full"
            :placeholder="props.placeholder"
        ></textarea>
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{ props.error }}</span>
        </label>
    </div>
</template>
