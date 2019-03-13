<template>
    <div>
        <fff-sortable-list v-model="model">
            <div slot-scope="{ items }">
                <fff-sortable-item v-for="block in items" :key="block.id">
                    <fff-matrix-block :block="block"
                                      :block-types="config.settings.blockTypes"></fff-matrix-block>
                </fff-sortable-item>
            </div>
        </fff-sortable-list>

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
    import FffSortableList from '../sortable/SortableList.vue';
    import FffSortableItem from '../sortable/SortableItem.vue';
    import FffMatrixBlock from './MatrixBlock.vue';

    export default {
        name: 'fff-matrix',
        props: ['config'],
        components: {
            FffSortableList,
            FffSortableItem,
            FffMatrixBlock
        },
        data() {
            return {
                model: this.config.value,
            }
        },
        methods:{
            onAddBlock (blockType) {
                // TODO make a new Block model from this BlockType
                this.model.push(blockType)
            }
        }
    };
</script>

<style>
    .draggable-source--is-dragging {
        opacity: 0.25;
    }
</style>