<template>
    <ModalPopUp height="250">
        <template v-slot:title>
          {{ 
            popupDetails.popup_data.teacher_id && popupDetails.popup_data.course_id ? 'Change teacher ('+popupDetails.popup_data.course_name+', '+popupDetails.popup_data.classroom_name+')':'Assign new course ('+popupDetails.popup_data.classroom_name+')' 
          }}
            </template>
            <template v-slot:contents>


                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

                <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" :message="errorStatus == 'assign_teacher_Modal.exist' ? 'Course name you selected is already assigned to another teacher' : '' ?? errorStatus.error " type="danger" :closeMethod="closeFeedback"/>
              

                <template v-if="!(popupDetails.popup_data.teacher_id && popupDetails.popup_data.course_id)">
                <p class="pt-1 text-sm font-semibold text-left">Select course: <span class=" text-red-600" title="Required field">(*)</span></p>
                <select @change='validate(messages,rules,formData,$event)'  name='course_id' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.course_id"  v-model="formData.course_id"  >
                    <option value=''>Select course</option>
                    <option v-for="course in getCoursesList" :value="course.course_id">{{ course.course_name }}</option>
                </select>  
                <div class="text-end">
                      <span class="text-red-600 text-xs" >{{messages.course_id.slot}}</span>
                </div>  
                </template>    
                
                
                <p class="pt-2 text-sm font-semibold text-left">Select teacher: <span class=" text-red-600" title="Required field">(*)</span></p>
                <select @change='validate(messages,rules,formData,$event)'  name='teacher_id' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.teacher_id"  v-model="formData.teacher_id"  >
                    <option value=''>Select user</option>
                    <option v-for="user in getUsersList" :value="user.account_id">{{ user.name }}</option>
                </select>  
                <div class="text-end">
                      <span class="text-red-600 text-xs" >{{messages.teacher_id.slot}}</span>
                </div> 
            </template>
            <template v-slot:buttons>
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="
        popupDetails.popup_data.teacher_id && popupDetails.popup_data.course_id ? changeTeacher() : assignCourse()" ><p class="flex text-center text-white pl-[20%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                   &nbsp;&nbsp;<font class='pt-1'>
            {{ 
              popupDetails.popup_data.teacher_id && popupDetails.popup_data.course_id ? 'Change':'Assign course' 
            }}
           
        </font> </p></button>
 </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { coursesStore } from '../../stores/courses'
import { useUserStore } from '../../stores/auth'
import { manageUserStore } from '../../stores/users'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations} from "../../helpers/validations"
import { useRoute } from 'vue-router'
import { uiChangesStore } from '../../stores/ui_changes'
import { classroomStore } from '../../stores/classroom'

export default {
      name:"assignCourse",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const coursesstores = coursesStore()
        const userStore = useUserStore()
        const manageUsers = manageUserStore()
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)   
        const uiStore = uiChangesStore();
        const classroomStores = classroomStore()


        const route = useRoute()

        const popupDetails = computed(() => uiStore.popupDetails)

    
        const formData = ref({
            course_id:uiStore.popupDetails.popup_data.course_id ?? "",
            teacher_id:uiStore.popupDetails.popup_data.teacher_id ?? "",
            classroom_id:uiStore.popupDetails.popup_data.class_id ?? "",
            school_id:"",
        });

        const rules = ref({
            course_id:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            teacher_id:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            }
        });

        const messages = ref({
            course_id:{
                required:"Course name field is required",
                slot:"",
                className:""
            },
            teacher_id:{
                required:"User field is required",
                slot:"",
                className:""
            },
        });

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        const getClassroomList = computed(() => {
            return coursesstores.classroomList.classrooms;
        });

        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = classroomStores.errorMessage != "" ? false : true
            successFeedbackStatus.value = classroomStores.successMessage != "" ? false : true
            return classroomStores.loadingUI
        });
        const errorStatus = computed(() => {
            errorFeedbackStatus.value = false
            return classroomStores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            successFeedbackStatus.value =false
            return classroomStores.successMessage
        });

        function courseList (school_id,class_id){
            return coursesstores.getcoursesList(school_id,class_id,1,'none')
        }

        const getCoursesList = computed(() => {
            return coursesstores.coursesList.Courses
        });



        function assignCourse(){
            if(validate(messages.value,rules.value,formData.value))
            {
               formData.value.classroom_id = uiStore.popupDetails.popup_data.class_id
               return classroomStores.designateTeacher(formData.value)
            }
        }

        function schoolUsers(school_id){
            return manageUsers.getSchoolUsers(school_id)
        }

        const getUsersList = computed(() => {
            return getUniqueListBy(manageUsers.usersList, 'account_id')
        });
        
        // Remove duplicates by account_id
        function getUniqueListBy(arr, key) {
            return [...new Map(arr.map(item => [item[key], item])).values()]
        }


        function changeTeacher(){
            return classroomStores.changeTeacherCourses(formData.value)
        }


        onMounted(() => {
            if(userStore.getUserData())
            {
                successFeedbackStatus.value = true
                errorFeedbackStatus.value = true
                
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                    const class_id = route.params.class_id
                    courseList (formData.value.school_id,class_id)
                    schoolUsers(formData.value.school_id)
                },1000);
            }
         })
        
        return {messages,rules,formData,slotData,getClassroomList,loadingStatus,validate,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,getCoursesList,assignCourse,getUsersList,popupDetails,changeTeacher}
       },
    }
    </script>

    