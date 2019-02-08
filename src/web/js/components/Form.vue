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
                model: {}
            }
        },
        methods: {
            onSubmit () {

                let hasErrors = false;

                // Compile field data and validate
                this.$slots.default.forEach(vNode => {
                    if (typeof vNode.children !== "undefined") {
                        let field = vNode.children[0].componentInstance;

                        if (typeof field.$refs.input !== "undefined") {

                            let input = field.$refs.input;

                            this.model[input.config.handle] = input.model;

                            input.$v.$touch();
                            if (input.$v.$invalid) {
                                hasErrors = true;
                            }
                        }

                    }
                });

                if (hasErrors) {
                    return;
                }

                // Call to the graphql mutation
                this.$apollo.mutate({
                    // Query
                    mutation: gql`
                        mutation ($title: String!) {
                            ${this.mutation}(title: $title) {
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