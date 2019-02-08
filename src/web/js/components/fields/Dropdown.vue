<template>
    <div>
        <div class="inline-block relative w-64">
            <select v-model="model"
                    :id="config.handle"
                    class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    :class="{'border-red': $v.model.$error}">
                <option v-for="opt in config.settings.options" :value="opt.value">{{opt.label}}</option>
            </select>
            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-dropdown',
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