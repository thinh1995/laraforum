<template>
  <v-toolbar>
    <v-toolbar-title>Lucifer</v-toolbar-title>
    <v-spacer></v-spacer>
    <app-notification v-if="loggedIn"></app-notification>
    <div>
      <template v-for="item in items">
        <router-link :to="item.to" v-if="item.show" :key="item.title">
          <v-btn text>{{ item.title }}</v-btn>
        </router-link>
      </template>
    </div>
  </v-toolbar>
</template>
<script>
import AppNotification from './AppNotification.vue';

export default {
  components: {
    AppNotification,
  },
  computed: {
    loggedIn() {
      return User.loggedIn();
    },
  },
  data() {
    return {
      items: [
        { title: 'Forum', to: '/forum', show: true },
        { title: 'Ask Question', to: '/ask', show: User.loggedIn() },
        { title: 'Category', to: '/category', show: User.admin() },
        { title: 'Login', to: '/login', show: !User.loggedIn() },
        { title: 'Logout', to: '/logout', show: User.loggedIn() },
      ],
    };
  },
  created() {
    EventBus.$on('logout', () => {
      User.logout();
    });
  },
};
</script>
<style lang="">
</style>
