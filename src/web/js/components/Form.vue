<template>
    <form @submit.prevent="onSubmit">
        <slot></slot>
        <button type="submit"
                v-if="!working"
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Save
        </button>
        <button disabled="disabled"
                v-if="working"
                class="bg-grey text-white font-bold py-2 px-4 rounded">
            Saving...
        </button>
    </form>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: 'fff-form',
        props: ['mutation'],
        data() {
            return {
                working: false,
                model: {},
                gqlTypes: "",
                gqlVars: "",
            }
        },
        methods: {

            clearFields () {
                this.$slots.default.forEach(vNode => {
                    if (typeof vNode.children !== "undefined") {
                        let field = vNode.children[0].componentInstance;
                        if (typeof field.$refs.input !== "undefined") {
                            field.$refs.input.model = null;
                            field.$refs.input.$v.$reset();
                        }
                    }
                });
            },

            onSubmit () {

                let hasErrors = false;
                this.gqlTypes = "";
                this.gqlVars = "";

                // Compile field data, gql vars and validate
                this.$slots.default.forEach(vNode => {
                    if (typeof vNode.children !== "undefined") {
                        let field = vNode.children[0].componentInstance;

                        if (typeof field.$refs.input !== "undefined") {

                            let input = field.$refs.input;

                            this.model[input.config.handle] = input.model;
                            this.gqlTypes += "$"+input.config.handle+":"+input.config.gqlType+",";
                            this.gqlVars += input.config.handle+":$"+input.config.handle+",";

                            input.$v.$touch();
                            if (input.$v.$invalid) {
                                hasErrors = true;
                            }
                        }

                    }
                });

                // Bail if there were field errors
                if (hasErrors) {
                    return;
                }

                // Trim trailing comma
                this.gqlVars = this.gqlVars.slice(0, -1)

                // Tell the user we’re doing something
                this.working = true;

                // Call to the graphql mutation
                this.$apollo.mutate({
                    // Query
                    mutation: gql`
                        mutation (${this.gqlTypes}) {
                            ${this.mutation}(${this.gqlVars}) {
                                id
                                slug
                                url
                                ${Object.keys(this.model).join(" ")}
                            }
                        }
                    `,
                    // Parameters
                    variables: this.model,
                })

                // Success
                .then((data) => {
                    this.working = false;
                    this.clearFields();


                    console.log(data);
                })

                // Failure
                .catch((error) => {

                    this.working = false;
                    console.error(error);
                });
            }
        }
    };
</script>