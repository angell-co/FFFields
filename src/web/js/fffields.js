import styles from '../css/fffields.pcss';

import Vue from 'vue';
import Form from './components/Form.vue';
import Field from './components/Field.vue';

const fffields = new Vue({
    el: "#fffields",
    delimiters: ['${', '}'],
    components: {
        'fff-form': Form,
        'fff-field': Field
    }
});