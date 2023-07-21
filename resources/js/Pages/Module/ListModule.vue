<template>
  <div class="mt-5 ml-5 mr-5 mb-5">
    <table
      class="w-full table-auto overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
    >
      <thead
        class="text-base border text-gray-700 uppercase text-left dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th class="px-6 py-3 border">#</th>
          <th class="px-6 py-3 border">Module</th>
          <th class="px-6 py-3 border">Action</th>
        </tr>
      </thead>
      <draggable
        class="dragArea list-group w-full"
        tag="tbody"
        :list="list"
        @end="saveOrder()"
      >
        <tr
          v-for="(smodule, index) in list"
          :key="index"
          class="bg-white text-sm text-gray-800 border-b dark:bg-gray-800 dark:border-gray-700"
        >
          <td class="px-6 py-4 w-3 border">{{ index + 1 }}</td>
          <td class="px-6 py-4 border">{{ smodule.name }}</td>
          <td class="px-6 py-4 border">
            <a
              type="button"
              class="btn btn-primary mr-2 bg-sky-500 text-white py-2 px-4 rounded border-gray-300"
              :href="
                '/project/' + project_id + '/module/' + smodule.id + '/actions'
              "
              >View</a
            >
            <a
              type="button"
              class="btn btn-primary mr-2 bg-white text-gray-500 py-2 px-4 rounded border-2 border-gray-300"
              :href="
                '/project/' + project_id + '/module/' + smodule.id + '/update'
              "
              >Edit</a
            >
            <a
              type="button"
              class="btn btn-primary mr-2 bg-white text-red-500 py-2 px-4 rounded border-2 border-red-500"
              :href="
                '/project/' + project_id + '/module/' + smodule.id + '/delete'
              "
              >Delete</a
            >
          </td>
        </tr>
      </draggable>
    </table>
  </div>
</template>
      
      <script>
import { defineComponent } from "vue";
import { VueDraggableNext } from "vue-draggable-next";

export default defineComponent({
  props: ["smodules","project_id"],
  components: {
    draggable: VueDraggableNext,
  },
  data() {
    return {
      list: [],
      originalOrder: [],
      updatedRowId: [],
      updatedRows: {},
      csrf: this.$page.props.csrf_token,
    };
  },
  created() {
    this.sortModule();
    this.initializeArray();
  },
  methods: {
    sortModule() {
      this.list = this.smodules;
      this.list.sort((a, b) => {
        return a.order - b.order;
      });
    },

    initializeArray() {
      this.originalOrder = JSON.parse(JSON.stringify(this.list));
    },

    saveOrder() {
      const updatedRow = this.list.filter((item, index) => {
        return item.id !== this.originalOrder[index].id;
      });

      updatedRow.forEach((item) => {
        this.updatedRowId.push(item.id);
      });

      for (let i = 0; i < updatedRow.length; i++) {
        this.updatedRows[i] = {
          id: 0,
          order: 0,
        };
      }

      let k = 0;
      this.list.forEach((item, index) => {
        if (this.updatedRowId.includes(item.id)) {
          this.updatedRows[k].id = item.id;
          this.updatedRows[k].order = index;
          k += 1;
        }
      });
      console.log(this.updatedRows);

      var url = "/api/modules/order/update",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          updatedModules: this.updatedRows,
        }),
        headers: {
          "content-type": "application/json",
          "X-CSRF-TOKEN": this.csrf,
        },
      })
        .then((response) => response.json())
        .then((response) => {
          if (response.success) {
            console.log(response.success);
          }
        })
        .catch((error) => console.log(error));
    }
  },
});
</script>
      