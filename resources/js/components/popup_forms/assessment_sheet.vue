<template>
    <ModalPopUp height=330>
        <template v-slot:title>
            Marks assessments 
            </template>
            <template v-slot:contents>
                <div v-if="loadingStatus.isLoading == false" >
                        <template v-if="classTeacherClassesList?.length > 0">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                        <router-link  v-for="a in (getUsers.authentications?.includes('add_course') ?  getClassroomList : classTeacherClassesList)" :value="a.class_id" :key="a.class_id" :to="`${toPage}/${a.class_id}`" @click="showPopUp()" class="flex w-full h-10 rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 hover:shadow-xl hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                            <strong class="pl-3 truncate">{{a.classroom_name}}</strong>
                        </router-link>
                        </div>
                        </template>
                        <template v-else>
                            <div class="flex w-full h-10 text-lg rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 "><p>There is no classrooms found</p></div>
                        </template>                   
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



export default {
      name:"assessmentSheet",
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

        const getClassroomList = computed(() => {
            return classroomstore.classroomList.classrooms;
        });

        const loadingStatus = computed(() => {
            return classroomstore.loadingUI
        });

        const toPage = computed(() => uiStore.to);

        const classTeacherClassesList = computed(() => userStore.class_teacher);

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        const getUsers = computed(() => userStore.userDetails);


        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    let school_id = userStore.userDetails.school_id
                    let page = 1
                    let limit = 'none'
                    classroomstore.getClassroomList(school_id,page,limit)
                },1000);
            }
         })
        return {slotData,getClassroomList,loadingStatus,toPage,showPopUp,classTeacherClassesList,getUsers}
       },
    }
    </script>

    