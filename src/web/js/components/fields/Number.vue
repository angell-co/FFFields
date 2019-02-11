<template>
    <div>
        <input v-model.number="model"
               :id="config.handle"
               :placeholder="config.settings.placeholder"
               :min="config.settings.min"
               :max="config.settings.max"
               :step="step"
               type="number"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
               :class="{'border-red': $v.model.$error}">

        <div v-if="$v.model.$error" class="text-red text-xs italic mt-2">
            <p v-if="!$v.model.required">{{config.name}} cannot be blank</p>
            <p v-if="config.settings.decimals === 0 && !$v.model.integer">{{config.name}} must be a number</p>
            <p v-if="config.settings.decimals > 0 && !$v.model.decimal">{{config.name}} must be a number</p>
            <p v-if="!$v.model.minValue">{{config.name}} must be no less than {{config.settings.min}}</p>
            <p v-if="!$v.model.maxValue">{{config.name}} must be no greater than {{config.settings.max}}</p>
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
                minValue: (typeof this.config.settings.min !== "") ? this.config.settings.min : false,
                maxValue: (typeof this.config.settings.max !== "") ? this.config.settings.max : false,
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
            
            if (this.config.settings.decimals > 0) {
                validationSchema.decimal = decimal;
            } else {
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