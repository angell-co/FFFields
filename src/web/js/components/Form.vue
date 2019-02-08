<template>
    <form @submit.prevent="onSubmit">
        <slot></slot>
        <button type="submit"
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Save
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
                model: {},
                gqlTypes: "",
                gqlVars: "",
            }
        },
        methods: {
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

                // Call to the graphql mutation
                this.$apollo.mutate({
                    // Query
                    mutation: gql`
                        mutation (${this.gqlTypes}) {
                            ${this.mutation}(${this.gqlVars}) {
                                id
                                url
                            }
                        }
                    `,
                    // Parameters
                    variables: this.model,
                }).then((data) => {
                    // Result
                    console.log(data)
                }).catch((error) => {
                    // Error
                    console.error(error)
                })
            },

        }
    };
</script>