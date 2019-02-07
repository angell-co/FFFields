<template>
    <div>
        <label class="block text-grey-darker text-sm font-bold mb-2"
               :for="config.handle">
            {{ config.name }}
        </label>
        <fff-plain-text :config="config"></fff-plain-text>
    </div>
</template>

<script>

    import PlainText from './fields/PlainText.vue';

    export default {
        name: 'fff-field',
        props: ['config'],
        components: {
            'fff-plain-text': PlainText
        },
        data() {
            return {
            }
        }
    };
</script>