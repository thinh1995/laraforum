import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../components/login/Login.vue';
import Logout from '../components/login/Logout.vue';
import Signup from '../components/login/Signup.vue';
import Forum from '../components/forum/Forum.vue';
import Read from '../components/forum/Read.vue';
import Create from '../components/forum/Create.vue';
import CreateCategory from '../components/category/CreateCategory.vue';

Vue.use(VueRouter);

const routes = [
  { path: '/login', component: Login },
  { path: '/logout', component: Logout },
  { path: '/signup', component: Signup },
  { path: '/forum', component: Forum, name: 'forum' },
  { path: '/question/:slug', component: Read, name: 'read' },
  { path: '/ask', component: Create },
  { path: '/category', component: CreateCategory },
];

const router = new VueRouter({
  routes, // short for `routes: routes`
  hashbang: false,
  mode: 'history',
});

export default router;
