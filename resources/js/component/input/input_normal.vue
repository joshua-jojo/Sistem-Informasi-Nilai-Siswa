<script setup>
import {defineEmits,ref,watch} from 'vue'
const props = defineProps({
    placeholder : String,
    error : String,
    length : Number,
    title : String,
    modelValue : String
})

const emit = defineEmits(['update:modelValue'])
const data_input = ref(props.modelValue)

watch(
    () => data_input.value,
    (new_input, old_input) => {
        if(data_input.value.length <= props.length){
            emit('update:modelValue', new_input)
        }
        else {
            data_input.value = old_input
        }
    }
)

</script>
<template lang="">
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">{{props.title}}</span>
            <span class="label-text-alt text-xs" v-if="props.length"> {{data_input.length}} / {{props.length}}</span>
        </label>
        <input
            :id="props.name"
            type="text"
            @input="data_input = $event.target.value"
            :value="props.modelValue"
            class="input input-sm input-bordered w-full"
            :placeholder="props.placeholder"
            autocomplete="off"
        />
        <label class="label" v-if="props.error">
            <span class="label-text-alt text-error">{{props.error}}</span>
        </label>
    </div>
</template>
