<template>
  <v-container>
    <v-form @submit.prevent="create()">
      <v-text-field v-model="form.title" label="Title" type="text" required></v-text-field>
      <v-select
        v-model="form.category_id"
        :items="categories"
        item-text="name"
        item-value="id"
        label="Category"
        autocomplete
      ></v-select>
      <vue-simplemde v-model="form.body" ref="markdownEditor" />
      <v-btn color="green" type="sumbit" :disabled="disabled">Create</v-btn>
    </v-form>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      form: {
        title: null,
        category_id: null,
        body: null,
      },
      categories: [],
      errors: [],
    };
  },
  computed: {
    disabled() {
      return !(this.form.title && this.form.category_id && this.form.body);
    },
  },
  methods: {
    create() {
      axios
        .post('/api/question', this.form)
        .then((res) => {
          this.$router.push(res.data.path);
        })
        .catch((err) => console.log(err.response.data));
    },
  },
  created() {
    axios
      .get('/api/category')
      .then((res) => {
        this.categories = res.data.data;
      })
      .catch((err) => {
        this.errors = err.response.data;
      });
  },
};
</script>
