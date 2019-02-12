<template>
    <div>
        <input v-model.number="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               :min="config.settings.min"
               :max="config.settings.max"
               :step="step"
               type="text"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
               :class="{'border-red': $v.model.$error}">

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
            <p v-if="integer && !$v.model.integer">{{config.name}} must be a number</p>
            <p v-if="decimal && !$v.model.decimal">{{config.name}} must be a number</p>
            <p v-if="minValue && !$v.model.minValue">{{config.name}} must be no less than {{config.settings.min}}</p>
            <p v-if="maxValue && !$v.model.maxValue">{{config.name}} must be no greater than {{config.settings.max}}</p>
        </div>
    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate';
    import { required,requiredIf,integer,decimal,minValue,maxValue } from 'vuelidate/lib/validators';

    export default {
        name: 'fff-number',
        props: ['config'],
        mixins: [validationMixin],
        data() {
            return {
                model: this.config.value,
                minValue: this.config.settings.min !== null ? this.config.settings.min : false,
                maxValue: this.config.settings.max !== null ? this.config.settings.max : false,
                decimal: this.config.gqlType === 'Float',
                integer: this.config.gqlType === 'Int',
                step: this.config.settings.decimals ? "0."+String("0").repeat(this.config.settings.decimals-1)+"1" : ""
            }
        },

        // TODO could do with proper decimal validation
        validations () {
            let validationSchema = {
                required: requiredIf(() => {
                    return this.config.required
                })
            }
            
            if (this.decimal) {
                validationSchema.decimal = decimal;
            }

            if (this.integer) {
                validationSchema.integer = integer;
            }

            if (this.minValue)
            {
                validationSchema.minValue = minValue(this.minValue);
            }

            if (this.maxValue)
            {
                validationSchema.maxValue = maxValue(this.maxValue);
            }

            return {
                model: validationSchema
            }
        }
    };
</script>