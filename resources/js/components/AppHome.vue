<template>
  <div>
    <toolbar></toolbar>
    <router-view></router-view>
    <app-footer></app-footer>
  </div>
</template>
<script>
import Toolbar from './Toolbar.vue';
import AppFooter from './AppFooter.vue';

export default {
  components: {
    Toolbar,
    AppFooter,
  },
};
</script>
<style>
</style>
