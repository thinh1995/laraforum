<template>
  <v-container fluid>
    <v-form @submit.prevent="update()">
      <v-card>
        <v-text-field v-model="form.title" label="Title" type="text" required></v-text-field>
        <vue-simplemde v-model="form.body" ref="markdownEditor" />
        <v-card-actions>
          <v-btn icon small type="submit">
            <v-icon color="teal">mdi-content-save</v-icon>
          </v-btn>
          <v-btn icon small @click="cancel()">
            <v-icon>mdi-close-circle</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-container>
</template>
<script>
export default {
  props: ['data'],
  data() {
    return {
      form: {
        title: null,
        body: null,
      },
    };
  },
  methods: {
    cancel() {
      EventBus.$emit('cancelEditing');
    },
    update() {
      axios
        .patch(`/api/question/${this.$route.params.slug}`, this.form)
        .then((res) => this.cancel())
        .catch((err) => console.log(err.response.data));
    },
  },
  created() {
    this.form = this.data;
  },
};
</script>
