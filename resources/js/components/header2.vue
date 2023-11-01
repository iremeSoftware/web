<template>
    <div class="w-full md:w-[85%] h-16 shadow-md bg-white fixed md:ml-[15%] ">
        <div class="flex pl-2 md:pl-10 pt-4">
          <p class="hidden md:block text-[17px] font-semibold">Dashboard</p>
          <div class="text-left">
            <button class="block md:hidden" @click="showLeftMenu()">
              <svg :class="isMenuClicked ? 'hidden':'block'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg :class="isMenuClicked ? 'block':'hidden'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          </div>
          <div class="w-full text-right space-x-4 pr-2">
            <button class=" h-8 w-8  text-center pl-2" @click="toggleNotification()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
          <span class="absolute bg-red-500 -mt-6 ml-[1px] h-3 w-3 rounded-full text-[8px] text-white">2</span>
          </button>

          
    <button @click="showPopUp('newUsers')" class="w-[150px] h-8 text-sm rounded-lg text-white bg-[#000000]"><p class="flex pl-2 pt-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 pb-1">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>Invite new user </p></button>

<div class="border-l-[2px]"></div>


          </div>

        </div>
      <div class="z-10 absolute md:ml-[59%] mt-2  w-full md:w-[40%] h-[300px] rounded-xl bg-[#ffffff] border-[2px] border-[#0673c3]  shadow-2xl" :class="notification==true?'block':'hidden'">
          <div class="hidden md:block z-20 w-4 h-4 bg-[#ffffff]  rotate-45 -mt-2 ml-[69%] border-t-[2px] border-l-[2px] border-[#0673c3] "></div>
        </div>
      </div>
     
      <template v-if="popup_type == 'add_student'">
        <newStudentForm />
      </template>
      <template v-else-if="popup_type =='classroomList'">
        <classroomListPopup />
      </template>
      <template v-else-if="popup_type == 'createClassroom'">
        <createClassroomModal />
      </template>
      <template v-else-if="popup_type == 'createCourses'">
        <createCoursesModal />
      </template>
      <template v-else-if="popup_type == 'newUsers'">
        <newUserModal />
      </template>
      <template v-else-if="popup_type == 'logout'">
        <LogoutPopUp />
      </template>
      <template v-else-if="popup_type == 'update_student'">
        <updateStudentPopup />
      </template>
      <template v-else-if="popup_type == 'assign_courses'">
        <assignNewCourse />
      </template>

      

</template>

<script>

import { ref,computed} from 'vue';
import { useUserStore } from '../stores/auth'
import { uiChangesStore } from '../stores/ui_changes'
import ModalPopUp from './ModalPopUp.vue';
import newStudentForm from './popup_forms/new_student.vue'
import classroomListPopup from './popup_forms/classroom_list.vue'
import createClassroomModal from './popup_forms/new_classroom.vue'
import createCoursesModal from './popup_forms/new_courses.vue'
import newUserModal from './popup_forms/new_user.vue'
import LogoutPopUp from './popup_forms/logout_prompt.vue'
import updateStudentPopup from './popup_forms/update_student.vue'
import assignNewCourse from './popup_forms/assign_courses.vue'

export default{
    name:"Header2",
    components:{
      ModalPopUp,
      newStudentForm,
      classroomListPopup,
      createClassroomModal,
      createCoursesModal,
      newUserModal,
      LogoutPopUp,
      updateStudentPopup,
      assignNewCourse
   },
    setup() {

      const notification = ref(false)
      const store = useUserStore();
      const uiStore = uiChangesStore();

      const popup_type = computed(() => uiStore.popup_type);

      let isMenuClicked = computed(() => uiStore.isMenuClicked);

      const popupDetails = computed(() => uiStore.popupDetails)

      function showLeftMenu(){
        isMenuClicked =! isMenuClicked
        return uiStore.isLeftMenuSelected(isMenuClicked)         
      }

      function toggleNotification(){
          notification.value =! notification.value
      }

      function showPopUp(popup_type){
      return uiStore.openPopUpFunc(popup_type);
      }

      return {toggleNotification,notification,showLeftMenu,isMenuClicked,popup_type,showPopUp,popupDetails}
        
    },
}
</script>
