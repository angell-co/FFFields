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

        <fff-url v-else-if="config.vueFieldType === 'url'"
                 ref="input"
                 :config="config"></fff-url>

        <fff-email v-else-if="config.vueFieldType === 'email'"
                   ref="input"
                   :config="config"></fff-email>

        <fff-lightswitch v-else-if="config.vueFieldType === 'lightswitch'"
                         ref="input"
                         :config="config"></fff-lightswitch>

        <fff-dropdown v-else-if="config.vueFieldType === 'dropdown'"
                      ref="input"
                      :config="config"></fff-dropdown>

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

    export default {
        name: 'fff-field',
        props: ['config'],
        components: {
            'fff-plain-text': PlainText,
            'fff-url': Url,
            'fff-email': Email,
            'fff-lightswitch': Lightswitch,
            'fff-dropdown': Dropdown
        }
    };
</script>