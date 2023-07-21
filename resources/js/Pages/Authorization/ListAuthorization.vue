<template>
  <inertia-head>
    <title>Authorization</title>
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
          <div class="mt-3 mr-5 flex justify-between">
            <a
              type="button"
              class="btn btn-primary ml-5 bg-gray-200 text-black font-bold py-2 px-4 rounded"
              :href="
                '/project/' + project.id + '/module/' + smodule.id + '/actions'
              "
              >Back</a
            >
            <a
              type="button"
              class="btn btn-primary float-right mr-2 bg-sky-400 text-white font-bold py-2 px-4 rounded"
              :href="
                '/project/' +
                project.id +
                '/module/' +
                smodule.id +
                '/action/' +
                action.id +
                '/authorization/edit'
              "
              >Edit</a
            >
          </div>
          <div class="mt-5 mr-5">
            <table
              class="w-11/12 ml-5 table-auto text-sm text-gray-500 dark:text-gray-400"
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
                    v-for="(check, index) in checkArray"
                    :key="index"
                  >
                    <span v-if="check">✔</span>
                    <span v-else>❌</span>
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
      checkArray: [],
      idArray: [],
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
          this.checkAuthorized();
        })
        .catch((error) => console.log(error));
    },

    checkAuthorized() {
      this.stakeholders.map((x) => {
        if (this.idArray.includes(x.id)) {
          this.checkArray.push(true);
        } else {
          this.checkArray.push(false);
        }
      });
    },
  },
});
</script>
    