/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import ItemListComponent from "./components/ItemListComponent";
import CreateItemComponent from "./components/CreateItemComponent";
import CategoryListComponent from "./components/CategoryListComponent";
import CreateCategoryComponent from "./components/CreateCategoryComponent";
import VueRouter from 'vue-router'

Vue.use(VueRouter);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('itemlist-component', ItemListComponent);
Vue.component('createitem-component', CreateItemComponent);
Vue.component('categorylist-component', CategoryListComponent);
Vue.component('createcategory-component', CreateCategoryComponent);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const ItemList = { template: '<itemlist-component></itemlist-component>' }
const CreateItem = { template: '<createitem-component></createitem-component>' }
const CategoryList = { template: '<categorylist-component></categorylist-component>' }
const CreateCategory = { template: '<createcategory-component></createcategory-component>' }
const Example = { template: '<example-component></example-component>' }

const routes = [
    { path: '/', component: ItemList },
    { path: '/createitem', component: CreateItem },
    { path: '/categorylist', component: CategoryList },
    { path: '/createcategory', component: CreateCategory },
    { path: '/example', component: Example },
]

const router = new VueRouter({
    mode: 'history',
    routes
})


const app = new Vue({
    router,
    el: '#app',
});
