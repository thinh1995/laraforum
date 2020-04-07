<template>
  <div>
    <reply v-for="(reply, index) in replies" :key="reply.id" :data="reply" :index="index"></reply>
  </div>
</template>
<script>
import Reply from './Reply.vue';

export default {
  components: {
    Reply,
  },
  props: ['replies'],
  data() {
    return {
      content: this.replies,
    };
  },
  methods: {
    listen() {
      EventBus.$on('newReply', (reply) => {
        this.content.unshift(reply);
      });

      EventBus.$on('deleteReply', (index) => {
        axios.delete(`/api/question/${this.$route.params.slug}/reply/${this.content[index].id}`)
          .then((res) => {
            this.content.splice(index, 1);
          })
          .catch((err) => console.log(err.response.data));
      });
    },
  },
  created() {
    this.listen();
  },
};
</script>
