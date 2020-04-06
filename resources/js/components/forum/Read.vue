<template>
  <div>
      <edit-question :data="data" v-if="editing"></edit-question>
      <div v-else>
        <show-question :data="data" v-if="data"></show-question>
      </div>
  </div>
</template>
<script>
import EditQuestion from './EditQuestion';
import ShowQuestion from "./ShowQuestion.vue";
export default {
  components: {
    EditQuestion,
    ShowQuestion
  },
  data() {
    return {
      data: null,
      editing: false
    };
  },
  created() {
    this.listen();
    this.getQuestion();
  },
  methods: {
    listen() {
      EventBus.$on("startEditing", () => {
        this.editing = true;
      });
      EventBus.$on("cancelEditing", () => {
        this.editing = false;
      });
    },
    getQuestion() {
      axios
        .get(`/api/question/${this.$route.params.slug}`)
        .then(res => (this.data = res.data.data))
        .catch(err => console.log(err.response.data));
    }
  }
};
</script>