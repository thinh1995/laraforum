<template>
  <v-card class="mt-3">
    <v-card-title>
      <div class="headline">{{ data.user }}</div>
      <div class="ml-2">said {{ data.created_at }}</div>
      <v-spacer></v-spacer>
      <like :content="data"></like>
    </v-card-title>
    <v-divider></v-divider>
    <edit-reply v-if="editing" :reply="data"></edit-reply>
    <v-card-text v-else v-html="reply"></v-card-text>
    <v-divider></v-divider>
    <v-card-actions v-if="!editing && own">
      <v-btn icon small @click="edit()">
        <v-icon color="orange">mdi-pencil</v-icon>
      </v-btn>
      <v-btn icon small @click="destroy()">
        <v-icon color="red">mdi-delete</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import EditReply from './EditReply.vue';
import Like from '../like/Like.vue';

export default {
  components: {
    EditReply,
    Like,
  },
  props: ['data', 'index'],
  data() {
    return {
      editing: false,
    };
  },
  computed: {
    own() {
      return User.own(this.data.user_id);
    },
    reply() {
      return md.parse(this.data.reply);
    },
  },
  methods: {
    destroy() {
      EventBus.$emit('deleteReply', this.index);
    },
    edit() {
      this.editing = true;
    },
    listen() {
      EventBus.$on('cancelEditing', () => {
        this.editing = false;
      });

      EventBus.$on('updateReply', (emitData) => {
        if (emitData.id === this.data.id) {
          axios.patch(`/api/question/${this.$route.params.slug}/reply/${this.data.id}`, { body: emitData.body })
            .then((res) => {
              this.data.reply = res.data.reply;
              this.editing = false;
            });
        }
      });
    },
  },
  created() {
    this.listen();
  },
};
</script>
