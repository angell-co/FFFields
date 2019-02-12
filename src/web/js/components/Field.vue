<template>
    <div>
        <label class="block text-grey-darker text-sm font-bold mb-2"
               :for="config.handle">
            {{ config.name }}
            <span v-if="config.required" class="text-red">*</span>
        </label>

        <p v-if="config.instructions"
           class="text-grey-dark text-xs italic mb-2">{{ config.instructions }}</p>

        <component :is="config.vueFieldType"
                   v-if="isValidFieldtype"
                   ref="input"
                   :config="config"></component>

        <div v-else class="bg-red-lightest border-l-4 border-red text-red-dark p-4" role="alert">
            <p class="font-bold mb-1">Field not supported</p>
            <p><code>{{config.type}}</code> is not currently supported, if you would like it to be then please <a href="https://github.com/angell-co/FFFields/issues" target="_blank" class="text-red-dark">file an issue</a>.</p>
        </div>
    </div>
</template>

<script>

    import PlainText from './fields/PlainText.vue';
    import Url from './fields/Url.vue';
    import Email from './fields/Email.vue';
    import Lightswitch from './fields/Lightswitch.vue';
    import Dropdown from './fields/Dropdown.vue';
    import MultiSelect from './fields/MultiSelect.vue';
    import RadioButtons from './fields/RadioButtons.vue';
    import Checkboxes from './fields/Checkboxes.vue';
    import Number from './fields/Number.vue';
    import Matrix from './fields/Matrix.vue';

    const components = {
        'fff-plain-text': PlainText,
        'fff-url': Url,
        'fff-email': Email,
        'fff-lightswitch': Lightswitch,
        'fff-dropdown': Dropdown,
        'fff-multi-select': MultiSelect,
        'fff-radio-buttons': RadioButtons,
        'fff-checkboxes': Checkboxes,
        'fff-number': Number,
        // 'fff-matrix': Matrix
    };

    export default {
        name: 'fff-field',
        props: ['config'],
        components: components,
        data () {
            return {
                isValidFieldtype: Object.keys(components).includes(this.config.vueFieldType)
            }
        }
    };
</script>