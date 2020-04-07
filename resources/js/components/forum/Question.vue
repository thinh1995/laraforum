<template>
  <v-card class="mt-2">
    <v-list-item three-line>
      <v-list-item-content>
        <v-list-item-title class="headline mb-1">
          <router-link :to="data.path">
            {{ data.title }}
          </router-link>
        </v-list-item-title>
        <v-list-item-subtitle class="grey--text">
          {{ data.user }} said {{ data.created_at }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-card-text>
      {{ data.body }}
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  props: ['data'],
};
</script>
