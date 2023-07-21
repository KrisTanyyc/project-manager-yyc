<template>
  <div class="flex m-10">
    <draggable class="dragArea list-group w-full" :list="list"
      @end="saveOrder()"
    >
      <div
        class="list-group-item bg-gray-300 m-1 p-3 rounded-md text-center"
        v-for="(element,index) in list"
        :key="element.name"
      >
        {{ element.name }} {{ index }}
      </div>
    </draggable>
  </div>
</template>
<script>
import { defineComponent } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
export default defineComponent({
  components: {
    draggable: VueDraggableNext,
  },
  data() {
    return {
      enabled: true,
      list: [
        { name: "John", id: 1 },
        { name: "Joao", id: 2 },
        { name: "Jean", id: 3 },
        { name: "Gerard", id: 4 },
      ],
      dragging: false,
      originalOrder: [],
      updatedRowId: [],
      updatedRows: {},
    };
  },
  created() {
    this.initializeArray();
  },
  methods: {
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
    },
  },
});
</script>