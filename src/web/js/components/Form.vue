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
            }
        },
        methods: {
            onSubmit () {
                console.log('submitted');
                console.log(this);
            }
        }
    };
</script>