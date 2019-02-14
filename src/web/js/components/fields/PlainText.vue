<template>
    <div>
        <input v-if="!config.settings.multiline"
               v-model="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               type="text"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
               :class="{'border-red': $v.model.$error}">
        <textarea v-if="config.settings.multiline"
                  v-model="model"
                  :id="config.handle"
                  :rows="config.settings.initialRows"
                  :placeholder="config.settings.placeholder"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
                  :class="{'border-red': $v.model.$error}"
        ></textarea>

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
            <p v-if="maxLength && !$v.model.maxLength">{{config.name}} should contain at most {{config.settings.charLimit}} characters</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf,maxLength } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-plain-text',
        props: ['config'],
        mixins: [validationMixin],
        data() {
            return {
                model: this.config.value,
                maxLength: (typeof this.config.settings.charLimit !== "undefined" && this.config.settings.charLimit !== "") ? this.config.settings.charLimit : false
            }
        },
        validations () {

            let validationSchema = {
                required: requiredIf(() => {
                    return this.config.required
                })
            }

            if (this.maxLength)
            {
                validationSchema.maxLength = maxLength(this.maxLength);
            }

            return {
                model: validationSchema
            }
        }
    };
</script>