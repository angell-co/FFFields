<template>
    <form @submit.prevent="onSubmit" novalidate class="m-0">
        <slot></slot>
        <button type="submit"
                v-if="!redirecting && !working"
                class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Save
        </button>
        <button disabled="disabled"
                v-if="working && !redirecting"
                class="bg-grey text-white font-bold py-2 px-4 rounded">
            Saving &hellip;
        </button>
        <button disabled="disabled"
                v-if="!working && redirecting"
                class="bg-grey text-white font-bold py-2 px-4 rounded">
            Redirecting &hellip;
        </button>
    </form>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: 'fff-form',
        props: {
            mutation: String,
            id: {
                type: Number,
                default: null
            },
            enabled: {
                type: Boolean,
                default: true
            },
            redirect: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                working: false,
                redirecting: false,
                model: {},
                gqlTypes: "",
                gqlVars: "",
            }
        },
        methods: {

            clearFields () {
                let fields = this.$children.filter(child => { return child.$options._componentTag === 'fff-field' });
                fields.forEach(field => {
                    if (typeof field.$refs.input !== "undefined") {
                        field.$refs.input.model = field.$refs.input.config.value;
                        if (typeof field.$refs.input.$v !== "undefined") {
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
                let fields = this.$children.filter(child => { return child.$options._componentTag === 'fff-field' });
                fields.forEach(field => {
                    if (typeof field.$refs.input !== "undefined") {

                        let input = field.$refs.input;

                        this.model[input.config.handle] = input.model;
                        this.gqlTypes += "$"+input.config.handle+":"+input.config.gqlType+",";
                        this.gqlVars += input.config.handle+":$"+input.config.handle+",";

                        if (typeof input.$v !== "undefined") {
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

                // Add any special attributes to the main model
                let postVars = {
                    ...this.model,
                    enabled: this.enabled,
                    id: this.id
                };

                // Trim trailing comma
                this.gqlTypes = this.gqlTypes.slice(0, -1);
                this.gqlVars = this.gqlVars.slice(0, -1);

                // Add the extra types and vars
                this.gqlTypes += ",$enabled:Boolean,$id:Int";
                this.gqlVars += ",enabled:$enabled,id:$id";

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
                                ${Object.keys(postVars).join(" ")}
                            }
                        }
                    `,
                    // Parameters
                    variables: postVars,
                })

                // Success
                .then((returnData) => {
                    this.working = false;

                    if (!this.id) {
                        this.clearFields();
                    }

                    if (this.redirect) {
                        this.redirecting = true;

                        let validTokens = {
                            '{id}': returnData.data[this.mutation].id,
                            '{slug}': returnData.data[this.mutation].slug,
                            '{url}': returnData.data[this.mutation].url
                        };

                        let redirect = this.redirect.replace(/{\w+}/g, function(all) {
                            return validTokens[all] || all;
                        });

                        window.location = redirect;
                    }
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