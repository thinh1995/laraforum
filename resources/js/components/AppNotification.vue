<template>
  <v-menu offset-y>
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-icon :color="color">mdi-bell</v-icon> {{ unreadCount }}
      </v-btn>
    </template>
    <v-list>
      <v-list-item
        v-for="item in unread"
        :key="'unred_' + item.id"
      >
        <router-link :to="item.path">
          <v-list-item-title @click="readIt(item)">{{ item.question }}</v-list-item-title>
        </router-link>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-item
        v-for="item in read"
        :key="'read_' + item.id"
      >
        <v-list-item-title>{{ item.question }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>
<script>
export default {
  data() {
    return {
      read: [],
      unread: [],
      unreadCount: 0,
      sound: 'http://soundbible.com/mp3/glass_ping-Go445-1207030150.mp3',
    };
  },
  computed: {
    color() {
      return this.unreadCount > 0 ? 'red' : 'red lighten-4';
    },
  },
  methods: {
    getNotifications() {
      axios.post('/api/notification')
        .then((res) => {
          this.read = res.data.read;
          this.unread = res.data.unread;
          this.unreadCount = res.data.unread.length;
        })
        .catch((err) => Exception.handle(err));
    },
    readIt(notification) {
      axios.post('/api/notification/markAsRead', { id: notification.id })
        .then((res) => {
          this.unread.splice(notification, 1);
          this.read.push(notification);
          this.unreadCount--;
        });
    },
    playSound() {
      const alert = new Audio(this.sound);
      alert.play();
    },
  },
  created() {
    if (User.loggedIn()) {
      this.getNotifications();

      Echo.private(`App.User.${User.id()}`)
        .notification((notification) => {
          this.playSound(this.sound);
          this.unread.unshift(notification);
          this.unreadCount++;
        });
    }
  },
};
</script>
