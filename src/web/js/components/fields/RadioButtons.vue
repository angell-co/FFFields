<template>
    <div>
        <input v-model="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               type="text"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
               :class="{'border-red': $v.model.$error}">

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-checkboxes',
        props: ['config'],
        mixins: [validationMixin],
        data() {
            return {
                model: this.config.value,
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
        }
    };
</script>