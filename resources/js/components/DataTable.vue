<template>
     <div class="md:ml-[19%] mt-10  w-full  shadow-lg bg-[#ffffff] rounded-2xl">
        <div class="flex w-full ">
          <div class="flex p-6 w-4/12 text-xs md:text-sm">
             <slot name="no_of_records"></slot>
          </div>
        <div class="w-2/12 md:w-6/12"></div>
         <div class="flex p-6 md:w-4/12 text-end text-xs md:text-sm">
          <p class="font-semibold mt-2 pr-2"> </p>
          <slot name="searchInput"></slot>
        </div>
      </div>
      <div v-if="slotData.columnsToShow" class="md:flex w-full text-xs md:text-sm pl-6 pt-4 ">
        <slot name="columnsToShow"></slot>
      </div>
      <div class="p-6">
        <slot name="table">
          
        </slot>
        <div class="flex w-full text-xs md:text-sm ">
          <div class="flex pl-1 pt-6 w-5/12 hidden md:block">
          <p class="text-sm font-semibold text-left mt-2 pr-2">
            <slot name="entries"></slot>
          </p>
          </div>
         <div class="w-2/12 md:w-6/12"></div>
         <slot name="pagination"></slot>
        </div>
        <div class="md:flex w-full text-xs md:text-sm pt-4 ">
          <template v-if="slotData.migrateSection">
            <slot name="migrateSection"></slot>
          </template>
          <template v-if="slotData.printBtns">
            <slot name="printBtns"></slot>
          </template>
        </div>
    </div>
</div>
</template>

<script>
import { ref, useSlots } from 'vue';

export default {
  name:"DataTable",
  setup() {
    const slots = useSlots()
    const slotData = ref(slots)

    return {slotData}
   },
}
</script>
