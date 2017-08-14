// Vue.component('example', require('./components/Example.vue'));
// register
// Vue.component('my-component', {
//     template: '<div>A custom component!</div>'
// })
const app = new Vue({
    el: '#app',
    components: {
        'my-component': {
            template: '<div>A custom component!</div>'
        },
    },
});
