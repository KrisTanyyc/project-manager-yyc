<template>
  <inertia-head>
    <title>Actions</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1"/>
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col h-auto w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="flex flex-col">
            <div class="mt-5 ml-5">
              <span class="font-bold text-3xl"
                >{{ project.name }}/{{ smodule.name }}/Actions</span
              >
            </div>
            <div class="mt-3 mr-5 flex justify-end">
              <a
                type="button"
                class="btn btn-primary mr-5 bg-gray-200 text-black font-bold py-2 px-4 rounded"
                :href="'/projects/' + project.id + '?tab=2'"
                >Back</a
              >
              <button
                @click="createBREAD()"
                class="btn btn-primary mr-3 bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :disabled="isButtonClicked"
              >
                + Create BREAD
              </button>
              <a
                type="button"
                class="btn btn-primary bg-sky-400 text-white font-bold py-2 px-4 rounded"
                :href="
                  '/project/' +
                  project.id +
                  '/module/' +
                  smodule.id +
                  '/action/create'
                "
              >
                + Create Action
              </a>
            </div>
            <div class="m-5">
              <table
                class="w-full table-auto overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
              >
                <thead
                  class="text-base border text-gray-700 uppercase text-left dark:bg-gray-700 dark:text-gray-400"
                >
                  <tr>
                    <th class="px-6 py-3 border">#</th>
                    <th class="px-6 py-3 border">Name</th>
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
                    v-for="(action, index) in list"
                    :key="index"
                    class="bg-white text-sm text-gray-800 border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                    <td class="px-6 py-4 w-3 border">{{ index + 1 }}</td>
                    <td class="px-6 py-4 border">{{ action.name }}</td>
                    <td class="px-6 py-4 border">
                      <a
                        type="button"
                        class="btn btn-primary mr-2 bg-white text-gray-500 py-2 px-4 rounded border-2 border-gray-300"
                        :href="
                          '/project/' +
                          project.id +
                          '/module/' +
                          smodule.id +
                          '/action/' +
                          action.id +
                          '/update'
                        "
                        >Edit</a
                      >
                      <a
                        type="button"
                        class="btn btn-primary mr-2 bg-white text-red-500 py-2 px-4 rounded border-2 border-red-500"
                        :href="
                          '/project/' +
                          project.id +
                          '/module/' +
                          smodule.id +
                          '/action/' +
                          action.id +
                          '/delete'
                        "
                        >Delete</a
                      >
                    </td>
                  </tr>
                </draggable>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
import { defineComponent } from "vue";
import NavBar from "../../NavBar/NavBar.vue";
import SideMenu from "../../Menu/Side-Menu.vue";
import { VueDraggableNext } from "vue-draggable-next";

export default defineComponent({
  props: ["project", "smodule", "actions_array"],
  components: {
    NavBar,
    SideMenu,
    draggable: VueDraggableNext,
  },
  data() {
    return {
      isButtonClicked: false,
      list: [],
      originalOrder: [],
      updatedRowId: [],
      updatedRows: {},
      csrf: this.$page.props.csrf_token,
    };
  },
  created() {
    this.sortAction();
    this.initializeArray();
  },
  methods: {
    sortAction() {
      this.list = this.actions_array.data;
      this.list.sort((a, b) => {
        return a.order - b.order;
      });
    },

    createBREAD() {
      this.isButtonClicked = true;
      var url = "/api/module/" + this.smodule.id + "/actionBREAD/create";
      fetch(url)
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          console.log(response);
          if (response.success) {
            window.location.href =
              "/project/" +
              this.project.id +
              "/module/" +
              this.smodule.id +
              "/actions";
          }
        })
        .catch((error) => {
          console.log(error);
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
      var url = "/api/actions/order/update",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          updatedActions: this.updatedRows,
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
    },
  },
});
</script>
  