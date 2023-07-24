<template>
  <inertia-head>
    <title>Snapshot</title>
  </inertia-head>
  <div class="flex flex-row h-full w-full">
    <SideMenu pageIndex="1" />
    <div class="flex flex-col flex-auto bg-white w-4/5 h-screen">
      <NavBar />
      <div class="flex flex-col h-auto w-full bg-white">
        <div
          class="flex flex-col w-full h-full border-blue-100"
          style="border-width: 20px"
        >
          <div class="mt-5 mb-5 ml-5 font-bold text-2xl">
            <span>Project:ABC Snapshot1 </span>
          </div>
          <div class="flex justify-end">
            <a
              type="button"
              class="btn btn-primary mr-2 mb-5 bg-gray-200 text-black py-2 px-4 rounded"
              href="/projects/31?tab=3"
              ><fa icon="fa-solid fa-angle-left" class="mr-2" />Back</a
            >
            <button
              type="button"
              class="btn btn-primary mr-5 mb-5 bg-sky-400 text-white font-bold py-2 px-4 rounded"
              @click="printPage()"
            >
              Print
            </button>
          </div>
          <div class="m-5">
            <table
              id="printTable"
              class="w-full table-fixed border-collapse overflow-x-auto text-sm text-gray-500 dark:text-gray-400"
            >
              <tbody>
                <tr
                  class="bg-white text-lg font-bold border-b dark:bg-gray-800 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    rowspan="2"
                    class="w-4/12 px-6 py-4 border whitespace-normal break-normal"
                  >
                    Module
                  </th>
                  <td class="px-6 py-4 border text-center w-2/12" rowspan="2">
                    Action
                  </td>
                  <td class="px-6 py-4 border text-center w-6/12" colspan="1">
                    Stakeholder
                  </td>
                </tr>
                <tr
                  class="bg-white text-center border-b dark:bg-gray-800 dark:border-gray-700"
                >
                  <td class="px-3 py-2 border">s</td>
                </tr>
                <tr
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                >
                  <th
                    scope="row"
                    class="px-6 py-4 text-base border font-medium whitespace-normal text-gray-900 dark:text-white"
                  >
                    fdsa
                  </th>
                  <td class="px-6 py-4 text-base text-center">
                    <ul>
                      <li>fdfs</li>
                    </ul>
                  </td>
                  <td class="px-6 py-4 text-center border">
                    <ul>
                      <li>
                        <span class="text-base text-stone-950">✓</span>
                      </li>
                    </ul>
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
  props: [],
  components: {
    NavBar,
    SideMenu,
  },
  data() {
    return {};
  },
  mounted() {},
  created() {},
  methods: {},
});
</script>
  

    
  