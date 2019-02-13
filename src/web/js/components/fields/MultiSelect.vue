<template>
    <div>
        <select v-model="model"
                multiple
                :id="config.handle"
                class="block appearance-none w-full bg-white border border-grey-light hover:border-grey py-2 px-3 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                :class="{'border-red': $v.model.$error}">
            <option v-for="opt in config.settings.options" :value="opt.value">{{opt.label}}</option>
        </select>

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-multi-select',
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