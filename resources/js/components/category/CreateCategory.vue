<template>
  <v-container>
    <v-form @submit.prevent="submit">
      <v-text-field v-model="form.name" label="Name" type="text" required></v-text-field>
      <v-btn color="pink" type="submit" :disabled="disabled" v-if="editSlug">Update</v-btn>
      <v-btn color="green" type="submit" :disabled="disabled" v-else>Submit</v-btn>
    </v-form>

    <v-card>
      <v-toolbar color="indigo" dark dense class="mt-2">
        <v-toolbar-title>Categories</v-toolbar-title>
      </v-toolbar>

      <v-list>
        <div v-for="(category, index) in categories" :key="category.id">
          <v-list-item>
            <v-list-item-action>
              <v-btn icon small @click="edit(category, index)">
                <v-icon color="orange">mdi-pencil</v-icon>
              </v-btn>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ category.name }}</v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-btn icon small @click="destroy(category, index)">
                <v-icon color="red">mdi-delete</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
          <v-divider></v-divider>
        </div>
      </v-list>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      form: {
        name: null,
      },
      categories: [],
      editSlug: null,
    };
  },
  computed: {
    disabled() {
      return !this.form.name;
    },
  },
  methods: {
    submit() {
      this.editSlug ? this.update() : this.create();
    },
    update() {
      axios.patch(`/api/category/${this.editSlug}`, this.form)
        .then((res) => {
          this.categories.unshift(res.data);
          this.form.name = null;
          this.editSlug = null;
        })
        .catch((err) => console.log(err.response.data));
    },
    create() {
      axios
        .post('/api/category', this.form)
        .then((res) => {
          this.categories.unshift(res.data);
          this.form.name = null;
        })
        .catch((err) => console.log(err.response.data));
    },
    destroy(category, index) {
      axios.delete(`/api/category/${category.slug}`)
        .then((res) => this.categories.splice(index, 1))
        .catch((err) => console.log(err.response.data));
    },
    edit(category, index) {
      this.editSlug = category.slug;
      this.form.name = category.name;
      this.categories.splice(index, 1);
    },
  },
  created() {
    if (!User.admin()) {
      this.$router.push({ name: 'forum' });
    }
    axios
      .get('/api/category')
      .then((res) => {
        this.categories = res.data.data;
      })
      .catch((err) => console.log(err.response.data));
  },
};
</script>
