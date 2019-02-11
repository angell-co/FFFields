<template>
    <div>
        <label v-for="opt in config.settings.options"
               :for="opt.name"
               class="block text-grey font-bold"
               :class="{'border-red': $v.model.$error}">
            <input  v-model="model"
                    :value="opt.value"
                    :id="opt.name"
                    type="radio"
                    class="mr-2 leading-tight">
            <span class="text-sm">
                {{opt.label}}
            </span>
        </label>

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-radiobuttons',
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