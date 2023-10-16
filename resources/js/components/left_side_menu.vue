<template>
    <div class="pt-4 text-[15px] group">
            <a href="#">
              <div class="h-10  group-hover:text-[#000000] group-hover:bg-[#f3f3f3]  mr-2 pl-2 pt-2 rounded-lg" :class="slotData.submenu ? 'group-hover:h-auto' : ''">
                <div class="flex space-x-3">
                    <slot name="icon"></slot>
                    <slot name="menu"></slot>

                  <span class="pl-[45%]">
                <template v-if="slotData.submenu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="block group-hover:hidden">
                   <path d="M10.0068 7.70683L14.2997 11.9997L10.0068 16.2926C9.81154 16.4879 9.81154 16.8045 10.0068 16.9997C10.2021 17.195 10.5186 17.195 10.7139 16.9997L15.3604 12.3533C15.4541 12.2595 15.5068 12.1323 15.5068 11.9997C15.5068 11.8671 15.4541 11.7399 15.3604 11.6462L10.7139 6.99972C10.6895 6.97531 10.6632 6.95395 10.6355 6.93565C10.4414 6.80751 10.1777 6.82886 10.0068 6.99972C9.81154 7.19498 9.81154 7.51156 10.0068 7.70683Z" fill="black"/>
                 </svg>
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hidden group-hover:block">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
                </template>
                </span>

                </div>
                <div v-if="slotData.submenu" class="mt-2 pl-4 hidden group-hover:block">
                        <slot name="submenu"></slot>
                </div>

            </div>
            </a>
          </div>
          
</template>

<script>
import { ref, useSlots } from 'vue';

export default {
  name:"LeftSideMenu",
  setup() {
    const slots = useSlots()
    const slotData = ref(slots)

    return {slotData}
   },
}
</script>
