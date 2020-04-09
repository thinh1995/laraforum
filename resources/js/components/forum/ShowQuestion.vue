<template>
  <v-card>
    <v-container fluid>
      <v-card-title>
        <div>
          <div class="headline">{{ data.title }}</div>
          <span class="grey--text">{{ data.user }} said {{ data.created_at }}</span>
        </div>
        <v-spacer></v-spacer>
        <v-btn color="teal" dark>{{ replyCount }} Replies</v-btn>
      </v-card-title>
      <v-card-text v-html="body"></v-card-text>
      <v-card-actions v-if="own">
        <v-btn icon small @click="edit()">
          <v-icon color="orange">mdi-pencil</v-icon>
        </v-btn>
        <v-btn icon small @click="destroy()">
          <v-icon color="red">mdi-delete</v-icon>
        </v-btn>
      </v-card-actions>
    </v-container>
  </v-card>
</template>
<script>
export default {
  props: ['data'],
  data() {
    return {
      own: User.own(this.data.user_id),
      replyCount: this.data.reply_count,
    };
  },
  computed: {
    body() {
      return md.parse(this.data.body);
    },
  },
  methods: {
    edit() {
      EventBus.$emit('startEditing');
    },
    destroy() {
      axios
        .delete(`/api/question/${this.$route.params.slug}`)
        .then((res) => this.$router.push({ name: 'forum' }))
        .catch((err) => console.log(err.response.data));
    },
    listen() {
      EventBus.$on('newReply', () => {
        this.replyCount++;
      });

      EventBus.$on('deleteReply', () => {
        this.replyCount--;
      });

      Echo.private(`App.User.${User.id()}`)
        .notification((notification) => {
          if (this.data.path === notification.path) {
            this.replyCount++;
          }
        });

      Echo.channel('deleteReplyChannel')
        .listen('DeleteReplyEvent', (e) => {
          const { replies } = this.data;
          for (let index = 0; index < replies.length; index++) {
            if (replies[index].id === e.id) {
              this.replyCount--;
            }
          }
        });
    },
  },
  created() {
    this.listen();
  },
};
</script>
