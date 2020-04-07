<template>
  <div>
    <vue-simplemde v-model="body" ref="markdownEditor" />
    <v-card-actions>
    <v-btn icon small @click="update()">
      <v-icon color="orange">mdi-content-save</v-icon>
    </v-btn>
    <v-btn icon small @click="cancel()">
      <v-icon color="red">mdi-close-circle</v-icon>
    </v-btn>
    </v-card-actions>
  </div>
</template>
<script>
export default {
  props: ['reply'],
  data() {
    return {
      id: this.reply.id,
      body: this.reply.reply,
    };
  },
  methods: {
    cancel() {
      EventBus.$emit('cancelEditing');
    },
    update() {
      EventBus.$emit('updateReply', { id: this.id, body: this.body });
    },
  },
};
</script>
