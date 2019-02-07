<template>
    <div>
        <input v-if="!config.settings.multiline"
               v-model="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               type="text"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline">
        <textarea v-if="config.settings.multiline"
                  v-model="model"
                  :id="config.handle"
                  :rows="config.settings.initialRows"
                  :placeholder="config.settings.placeholder"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"></textarea>
    </div>
</template>

<script>
    export default {
        name: 'fff-plain-text',
        props: ['config'],
        data() {
            return {
                model: null
            }
        }
    };
</script>