<template>
    <div>
        <span class="border rounded-full border-grey flex items-center cursor-pointer w-12 focus:outline-none focus:shadow-outline"
              tabindex="0"
              :id="config.handle"
              :class="{
                'justify-start': !this.model,
                'bg-green justify-end': this.model
              }"
              @click="model = !model"
              @keydown="onKeyDown">
            <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow"></span>
        </span>
    </div>
</template>

<script>
    export default {
        name: 'fff-lightswitch',
        props: ['config'],
        data() {
            return {
                model: this.config.value,
            }
        },
        methods: {
            onKeyDown ($ev) {
                switch ($ev.keyCode) {

                    // Space
                    case 32:
                        this.model = !this.model;
                        break;

                    // Right (on)
                    case 39:
                        this.model = true;
                        break;

                    // Left (off)
                    case 37:
                        this.model = false;
                        break;
                }
            }
        }
    };
</script>