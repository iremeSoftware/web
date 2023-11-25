<template>
   <div class="flex md:w-[49%]  md:h-40  ring-1 ring-black shadow-xl mt-4 p-2 md:ml-2">
      <div class="md:w-2/12">
        <p class="absolute hidden md:block pt-1 md:pt-8 pl-4 text-lg font-bold">Rank</p>
        <div class="absolute  w-[70px] h-8  bg-black text-white text-center pl-2 text-2xl md:mt-16 md:ml-2 ">
          <dt> <slot name="rank"></slot></dt>
        </div>
      </div>
      <div class="w-full md:w-10/12 text-center md:-ml-4">
        <p class="text-xl mt-2 mb-2 font-semibold"><slot name="student_name"></slot></p>
        <hr>
        <div class="md:flex pt-2">
          <div class="flex md:w-6/12 ">
            <label class="text-xs mt-2 md:mt-4">Quiz Points:</label>
            <slot name="quiz_points"></slot>
          </div>
          <div class="border-l-[4px] -mt-1  mr-10"></div>
          <div class="flex md:w-6/12 mt-4 md:mt-0">
            <label class="text-xs mt-2 md:mt-4">Exam Points:</label>
            <slot name="exam_points"></slot>
          </div>
        </div>
        <div class="flex pt-2">
          <div class="flex w-6/12">
            <label class="text-xs font-semibold"> <slot name="total_quiz_points"></slot></label>
          </div>
          <div class="flex w-6/12">
            <label class="text-xs md:ml-6 font-semibold"><slot name="total_exam_points"></slot></label>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { ref, useSlots } from 'vue';

export default {
 name:"StudentPointsCard",
 setup() {
   const slots = useSlots()
   const slotData = ref(slots)

   return {slotData}
  },
}
</script>
