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
        data() {
            return {
                model: {}
            }
        },
        methods: {
            onSubmit () {
                this.$slots.default.forEach(vNode => {
                    if (typeof vNode.children !== "undefined") {
                        let c = vNode.children[0].componentInstance;
                        this.model[c.config.handle] = c.model;
                    }
                });

                // Call to the graphql mutation
                this.$apollo.mutate({
                    // Query
                    mutation: gql`mutation ($title: String!) {
                        upsertNews(title: $title) {
                            id
                            url
                        }
                    }`,
                    // Parameters
                    variables: {
                        title: this.model.title,
                    },
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