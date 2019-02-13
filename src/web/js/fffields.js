// Styles
import fffstyles from '../css/fffields.pcss';


// State
const initialState = window.fffields;


// Apollo
import ApolloClient from 'apollo-boost';

const apolloClient = new ApolloClient({
    // You should use an absolute URL here
    uri: initialState.gqlEndpoint,
    headers: {
        "Authorization": "bearer "+initialState.token
    }
});


// Vue
import Vue from 'vue';
import VueApollo from 'vue-apollo';

Vue.use(VueApollo);
const apolloProvider = new VueApollo({
    defaultClient: apolloClient,
})


// Components
import Form from './components/Form.vue';
import Field from './components/Field.vue';


// App
const fffields = new Vue({
    el: "#fffields",
    delimiters: ['${', '}'],
    apolloProvider,
    components: {
        'fff-form': Form,
        'fff-field': Field
    }
});