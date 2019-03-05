<template>
    <div>
        <div v-for="block in model"
             class="border rounded w-full bg-white mb-4">
            <div class="bg-grey-light p-2 text-xs uppercase font-bold">
                {{block.name}}
                <svg class="fill-current w-3 h-3 float-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352.201 425.775l-79.196 79.196c-9.373 9.373-24.568 9.373-33.941 0l-79.196-79.196c-15.119-15.119-4.411-40.971 16.971-40.97h51.162L228 284H127.196v51.162c0 21.382-25.851 32.09-40.971 16.971L7.029 272.937c-9.373-9.373-9.373-24.569 0-33.941L86.225 159.8c15.119-15.119 40.971-4.411 40.971 16.971V228H228V127.196h-51.23c-21.382 0-32.09-25.851-16.971-40.971l79.196-79.196c9.373-9.373 24.568-9.373 33.941 0l79.196 79.196c15.119 15.119 4.411 40.971-16.971 40.971h-51.162V228h100.804v-51.162c0-21.382 25.851-32.09 40.97-16.971l79.196 79.196c9.373 9.373 9.373 24.569 0 33.941L425.773 352.2c-15.119 15.119-40.971 4.411-40.97-16.971V284H284v100.804h51.23c21.382 0 32.09 25.851 16.971 40.971z"></path></svg>
            </div>

            <div class="p-2 ">
                <pre>{{block}}</pre>
            </div>
        </div>

        <div class="inline-flex">
            <button v-for="blockType in config.settings.blockTypes"
                    @click="onAddBlock(blockType)"
                    type="button"
                    class="bg-grey-light hover:bg-grey text-grey-darkest font-bold py-2 px-4 focus:outline-none focus:shadow-outline inline-flex items-center"
                    :class="{
                        'rounded-l': Number(blockType.sortOrder) === 1,
                        'rounded-r': Number(blockType.sortOrder) === config.settings.blockTypes.length
                    }">
                <svg v-if="Number(blockType.sortOrder) === 1" class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                <span>{{blockType.name}}</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'fff-matrix',
        props: ['config'],
        data() {
            return {
                model: this.config.value,
            }
        },
        methods:{
            onAddBlock (blockType) {
                this.model.push(blockType)
            }
        }
    };
</script>