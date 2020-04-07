<template>
  <div v-if="question">
    <edit-question :data="question" v-if="editing"></edit-question>
    <show-question :data="question" v-else></show-question>
    <v-container>
      <replies :replies="question.replies"></replies>
        <new-reply></new-reply>
    </v-container>
  </div>
</template>
<script>
import EditQuestion from './EditQuestion.vue';
import ShowQuestion from './ShowQuestion.vue';
import Replies from '../reply/Replies.vue';
import NewReply from '../reply/NewReply.vue';

export default {
  components: {
    EditQuestion,
    ShowQuestion,
    Replies,
    NewReply,
  },
  data() {
    return {
      question: null,
      editing: false,
    };
  },
  created() {
    this.listen();
    this.getQuestion();
  },
  methods: {
    listen() {
      EventBus.$on('startEditing', () => {
        this.editing = true;
      });
      EventBus.$on('cancelEditing', () => {
        this.editing = false;
      });
    },
    getQuestion() {
      axios
        .get(`/api/question/${this.$route.params.slug}`)
        .then((res) => {
          this.question = res.data.data;
        })
        .catch((err) => console.log(err.response.data));
    },
  },
};
</script>
