<template>
    <div>
        <label class="block text-grey-darker text-sm font-bold mb-2"
               :for="config.handle">
            {{ config.name }}
            <span v-if="config.required" class="text-red">*</span>
        </label>

        <p v-if="config.instructions"
           class="text-grey-dark text-xs italic mb-2">{{ config.instructions }}</p>

        <fff-plain-text v-if="config.vueFieldType === 'plainText'"
                        ref="input"
                        :config="config"></fff-plain-text>

        <div v-else class="bg-red-lightest border-l-4 border-red text-red-dark p-4" role="alert">
            <p class="font-bold mb-1">Field not supported</p>
            <p><code>{{config.type}}</code> is not currently supported, if you would like it to be then please <a href="https://github.com/angell-co/FFFields/issues" target="_blank" class="text-red-dark">file an issue</a>.</p>
        </div>
    </div>
</template>

<script>

    import PlainText from './fields/PlainText.vue';

    export default {
        name: 'fff-field',
        props: ['config'],
        components: {
            'fff-plain-text': PlainText
        }
    };
</script>