<template>
  <inertia-head>
    <title>Update Authorization</title>
  </inertia-head>

  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1"/>
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col flex-auto h-4/5 w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-5 ml-5">
            <span class="font-bold text-2xl"
              >{{ project.name }}/{{ smodule.name }}/{{ action.name }}</span
            >
          </div>
          <div class="mt-5 mr-5">
            <a
              type="button"
              class="btn btn-primary ml-5 bg-gray-200 text-black font-bold py-2 px-4 rounded"
              :href="
                '/project/' +
                project.id +
                '/module/' +
                smodule.id +
                '/action/' +
                action.id +
                '/authorization'
              "
            >
              Back
            </a>
            <button
              @click="checkAuthorized()"
              class="btn btn-primary float-right mr-2 bg-sky-400 text-white font-bold py-2 px-4 rounded"
            >
              Save
            </button>
          </div>
          <div class="mt-10 mr-5">
            <table
              class="w-11/12 ml-5 table-fixed text-sm text-gray-500 dark:text-gray-400"
            >
              <thead
                class="text-base border text-gray-700 uppercase text-left dark:bg-gray-700 dark:text-gray-400"
              >
                <tr>
                  <th class="px-6 py-3 border" rowspan="2">#</th>
                  <th class="px-6 py-3 border" rowspan="2">Action Name</th>
                  <th
                    class="px-6 py-3 border text-center"
                    :colspan="lengthOfStakeholder"
                  >
                    Stakeholder
                  </th>
                </tr>
                <tr>
                  <th
                    class="px-3 py-2 border text-center"
                    v-for="(stakeholder, index) in stakeholders"
                    :key="index"
                  >
                    {{ stakeholder.name }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="bg-white text-sm text-gray-800 border-b dark:bg-gray-800 dark:border-gray-700"
                >
                  <td class="px-6 py-4 w-3 border">1</td>
                  <td class="px-6 py-4 border">{{ action.name }}</td>
                  <td
                    class="px-6 py-4 border text-center"
                    v-for="(stakeholder, index) in stakeholders"
                    :key="index"
                  >
                    <input
                      id="default-checkbox"
                      type="checkbox"
                      :true-value="stakeholder.id"
                      :false-value="null"
                      v-model="authorizedArray[index]"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
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

export default defineComponent({
  props: ["project", "action", "smodule", "stakeholders"],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {
      lengthOfStakeholder: this.stakeholders.length,
      idArray: [],
      authorizedArray: [],
      addIds: [],
      deleteIds: [],
      csrf: this.$page.props.csrf_token,
    };
  },
  created() {
    this.fetchAuthorizedArray();
  },
  methods: {
    fetchAuthorizedArray() {
      var url = "/api/action/" + this.action.id + "/authorization";
      fetch(url)
        .then((response) => response.json())
        .then((response) => {
          this.idArray = response;
          console.log(this.idArray);
        })
        .catch((error) => console.log(error));
    },

    checkAuthorized() {
      this.addIds = [];
      this.deleteIds = [];
      console.log("authorizedArray,", this.authorizedArray);
      this.authorizedArray.map((x) => {
        if (x !== null && this.idArray && !this.idArray.includes(x)) {
          console.log("x: ", x);
          this.addIds.push(x);
        }
        // else if (x!== null && this.idArray && this.idArray.includes(x)) {
        //   this.deleteId = this.idArray.filter((a) => {
        //     return a !== x;
        //   })
        // }
      });
      this.idArray.map((x) => {
        if (this.authorizedArray && !this.authorizedArray.includes(x)) {
          this.deleteIds.push(x);
        }
      });
      if (
        this.authorizedArray.every((element) => element === null) ||
        this.authorizedArray.length === 0
      ) {
        this.deleteIds = this.idArray;
      }
      console.log("addIds, ", this.addIds);
      console.log("deleteIds, ", this.deleteIds);
      this.updateAuthorization();
    },

    updateAuthorization() {
      var url = "/api/action/" + this.action.id + "/authorization",
        method = "post";
      fetch(url, {
        method: method,
        body: JSON.stringify({
          addIds: this.addIds,
          deleteIds: this.deleteIds,
        }),
        headers: {
          "content-type": "application/json",
          "X-CSRF-TOKEN": this.csrf,
        },
      })
        .then((response) => {
          return response.json();
        })
        .then((response) => {
          if (response.success) {
            console.log(response);
            window.location.href =
              "/project/" +
              this.project.id +
              "/module/" +
              this.smodule.id +
              "/action/" +
              this.action.id +
              "/authorization";
          }
        })
        .catch((error) => console.log("Error updating module: ", error));
    },
  },
});
</script>
      