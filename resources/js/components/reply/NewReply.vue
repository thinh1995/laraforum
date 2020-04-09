<template>
  <div class="mt-4">
    <vue-simplemde v-model="body" ref="markdownEditor" />
    <v-btn color="green" dark @click="submit()" :disabled="disabled">Reply</v-btn>
  </div>
</template>
<script>
export default {
  data() {
    return {
      body: null,
    };
  },
  computed: {
    disabled() {
      return !this.body;
    },
  },
  methods: {
    submit() {
      axios.post(`/api/question/${this.$route.params.slug}/reply`, { body: this.body })
        .then((res) => {
          this.body = '';
          EventBus.$emit('newReply', res.data.reply);
          window.scrollTo(0, 0);
        })
        .catch((err) => console.log(err.response.data));
    },
  },
};
</script>
