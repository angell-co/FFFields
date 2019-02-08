<template>
    <div>
        <input v-if="!config.settings.multiline"
               v-model="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               type="text"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
               :class="{
                   'border-red': $v.model.$error
               }">
        <textarea v-if="config.settings.multiline"
                  v-model="model"
                  :id="config.handle"
                  :rows="config.settings.initialRows"
                  :placeholder="config.settings.placeholder"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                  :class="{
                      'border-red': $v.model.$error
                  }"
        ></textarea>

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} is required</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-plain-text',
        props: ['config'],
        mixins: [validationMixin],
        data() {
            return {
                model: null
            }
        },
        validations () {
            return {
                model: {
                    required: requiredIf(() => {
                        return this.config.required
                    })
                }
            }
        },
        // watch: {
        //     model(val) {
        //         this.$emit('input', val);
        //     }
        // }
    };
</script>