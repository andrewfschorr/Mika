
// register
// Vue.component('my-component', {
//     template: '<div>A custom component!</div>'
// })
Vue.component('example', require('./components/Example.vue'));
const app = new Vue({
    el: '#app',
    // components: {
    //     'my-component': {
    //         template: '<div>A custom component!</div>'
    //     },
    // },
});
