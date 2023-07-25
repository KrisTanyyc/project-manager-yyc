<template>
  <div class="m-5">
    <table
      class="w-full table-auto overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
    >
      <thead
        class="text-base border text-gray-700 uppercase text-left dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th class="px-6 py-3 border">#</th>
          <th class="px-6 py-3 border">Snapshot</th>
          <th class="px-6 py-3 border">Action</th>
        </tr>
      </thead>

      <tr v-for="(snapshot, index) in snapshots" :key="index"
        class="bg-white text-sm text-gray-800 border-b dark:bg-gray-800 dark:border-gray-700"
      >
        <td class="px-6 py-4 w-3 border">{{ index + 1 }}</td>
        <td class="px-6 py-4 border">{{ snapshot.name }}</td>
        <td class="px-6 py-4 border">
            <a
            type="button"
            class="btn btn-primary mr-2 bg-sky-500 text-white py-2 px-4 rounded border-gray-300"
            :href='"/project/" + project_id + "/snapshot/" + snapshot.id'
            >View</a
          >
          <a
            type="button"
            class="btn btn-primary mr-2 bg-white text-red-500 py-2 px-4 rounded border-2 border-red-500"
            :href='"/project/" + project_id + "/snapshot/" + snapshot.id + "/delete"'
            >Delete</a
          >
        </td>
      </tr>
    </table>
  </div>
</template>
      
      <script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ['snapshots','project_id'],
  components: {},
  data() {
    return {};
  },
  created() {},
  methods: {},
});
</script>
      