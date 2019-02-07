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
    export default {
        name: 'fff-form',
        components: {},
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
            }
        }
    };
</script>