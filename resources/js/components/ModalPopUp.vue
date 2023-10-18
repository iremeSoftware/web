<template>

<!-- Main modal -->
<div class="fixed bg-black bg-opacity-75 h-full w-full" :class="isPopUpOpened ? 'block':'hidden'">
<div id="defaultModal" tabindex="-1" aria-hidden="true" class=" top-0 left-0 right-0 z-50 block w-full p-4  ">
    <div class="relative mt-[3%] md:mx-[30%] w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <slot name="title"></slot>
                </h3>
                <button type="button" @click="showPopUp()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6 h-[600px] overflow-y-auto">
                <slot name="contents"></slot>
            </div>
            <!-- Modal footer -->
            <div class="text-end items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-600">
                <slot name="buttons"></slot>
            </div>

        </div>
    </div>
</div>
</div>
</template>

<script>
    import { ref, useSlots,computed } from 'vue';
    import { uiChangesStore } from '../stores/ui_changes'
    
    export default {
      name:"ModalPopUp",
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const uiStore = uiChangesStore()
        const isPopUpOpened = computed(() => uiStore.isPopUpOpened)

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }
        return {slotData,isPopUpOpened,showPopUp}
       },
    }
    </script>