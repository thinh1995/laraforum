<template>
  <v-btn icon @click="likeIt()">
    <v-icon :color="color">mdi-heart</v-icon> {{ count }}
  </v-btn>
</template>
<script>
export default {
  props: ['content'],
  data() {
    return {
      liked: this.content.liked,
      count: this.content.like_count,
    };
  },
  computed: {
    color() {
      return this.liked ? 'red' : 'red lighten-4';
    },
  },
  methods: {
    likeIt() {
      if (User.loggedIn()) {
        this.liked ? this.decr() : this.incr();
        this.liked = !this.liked;
      }
    },
    incr() {
      axios.post(`/api/like/${this.content.id}`)
        .then((res) => this.count++)
        .catch((err) => console.log(err));
    },
    decr() {
      axios.delete(`/api/like/${this.content.id}`)
        .then((res) => this.count--)
        .catch((err) => console.log(err));
    },
  },
};
</script>
