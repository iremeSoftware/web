<template>
    <ModalPopUp height=330>
        <template v-slot:title>
            Switch schools
            </template>
            <template v-slot:contents>
                <div v-if="loadingStatus.isLoading == false" class="grid grid-cols-1 gap-4">
                    <button  v-for="a in getSchoolsList" :value="a.class_id" :key="a.class_id" @click="switchSchool(a.school_id)" class="flex w-full h-10 rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 hover:shadow-xl hover:scale-105">
                        <img  :src="'/school_logo/' +a.logo" class="h-[30px] w-[30px] rounded-full">
                        <strong class="truncate pl-3">{{a.school_name}}</strong>
                    </button>
                </div>
                <div v-else  class="pl-[40%]">
                    <svg class="animate-spin text-black h-14 w-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>               
            </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { classroomStore } from '../../stores/classroom'
import { useUserStore } from '../../stores/auth'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import { uiChangesStore } from '../../stores/ui_changes'
import { manageUserStore } from '../../stores/users'




export default {
      name:"switchSchoolsPopup",
     components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const classroomstore = classroomStore()
        const userStore = useUserStore()
        const uiStore = uiChangesStore();
        const manageUsers = manageUserStore()


        const getSchoolsList = computed(() => {
            return manageUsers.schools_list;
        });

        const loadingStatus = computed(() => {
            return classroomstore.loadingUI
        });

        const toPage = computed(() => uiStore.to);

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        function switchSchool(school_id){
            localStorage.setItem('school_id',school_id);;
            window.location.href='';
        }


        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    manageUsers.getAllAuthentications(userStore.userDetails.account_id)
                },1000);
            }
         })
        return {slotData,loadingStatus,toPage,showPopUp,getSchoolsList,switchSchool}
       },
    }
    </script>

    