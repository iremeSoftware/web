<template>
    <ModalPopUp height=330>
        <template v-slot:title>
            Select Classroom 
            </template>
            <template v-slot:contents>
                <div v-if="loadingStatus.isLoading == false" >
                    <template v-if="getClassroomList?.length > 0">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                           
                            <button  v-for="a in getClassroomList" :value="a.class_id" :key="a.class_id"  @click="selectCourse(a.class_id)" class="flex w-full h-10 rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 hover:shadow-xl hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                            </svg>
                                <strong class="pl-3 truncate">{{a.classroom_name}}</strong>
                            </button>
                        </div>
                        <template v-if="getCoursesList?.length">
                                <h5 class="font-semibold text-lg mt-4 mb-2">Select Course Below:</h5>
                                <div class="grid grid-cols-2  gap-4">
                            <button  v-for="course in getCoursesList" :value="course.course_id" :key="course.class_id"   @click="chooseCourse(course.course_id,course.class_id)" class="flex w-full h-10 rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 hover:shadow-xl hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                <strong class="pl-3 truncate">{{course.course_name}}</strong>
                              </button> 
                                </div>

                            </template>
                    </template>
                    <template v-else>
                        <div class="flex w-full h-10 text-lg rounded-md background-transparent ring-2 ring-[#000000] pl-4 pt-2 "><p>There is no assigned classrooms</p></div>
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
import { coursesStore } from '../../stores/courses'
import { useRoute,useRouter } from 'vue-router'





export default {
     name:"teacherClassroomListPopup",
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
        const coursesstores = coursesStore();
        const store = useUserStore()
        const route = useRoute()
        const router = useRouter()


        const formData = ref({
              student_name:"",
              school_id:"",
              class_id:"",
              page:1,
              account_id:"",
              course_id:localStorage.getItem('course_id'),
              limit:localStorage.getItem('numRows') ?? 10,
              sort_by:'name',
              sort:'ASC',
              term:1,
              maximumPoints:{

              }
      });


        const getClassroomList = computed(() => {
            return classroomstore.designateClassrooms.class_room;
        });

        const loadingStatus = computed(() => {
            return classroomstore.loadingUI
        });

        const toPage = computed(() => uiStore.to);

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        function getCoursesOfTeacherInClass(data){
           return coursesstores.getCoursesOfTeacherInClass(data)
        }

        const getCoursesList = computed(() => {
            return coursesstores.coursesList.courses
        });

        function selectCourse(class_id){
            formData.value.class_id = class_id
            formData.value.account_id = store.userDetails.account_id
            getCoursesOfTeacherInClass(formData.value)
        }

        function chooseCourse(course_id,class_id){
            localStorage.setItem('course_id',course_id)
            showPopUp()
            uiStore.popupDetails.course_id = course_id
            window.location.href='/dashboard/marks/'+class_id
            // router.push({path:'/dashboard/marks/'+class_id})
        }


        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    classroomstore.getClassroomsByDesignatedTeacher(userStore.userDetails)
                },1000);
            }
         })
        return {slotData,getClassroomList,loadingStatus,toPage,showPopUp,selectCourse,formData,getCoursesList,chooseCourse}
       },
    }
    </script>

    