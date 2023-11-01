<template>
    <ModalPopUp height="100">
        <template v-slot:title>
            Assign new course
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

                <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" :message="errorStatus.error.course_name  == 'add_new_course_Modal.course_exist' ? 'Course name you entered is already exists' : '' ?? errorStatus.error " type="danger" :closeMethod="closeFeedback"/>

                <p class="pt-2 text-sm font-semibold text-left">Select course: <span class=" text-red-600" title="Required field">(*)</span></p>
                <select @change='validate(messages,rules,formData,$event)'  name='course_name' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.course_name"  v-model="formData.course_name"  >
                            <option value=''>Select priority phone</option>
                            <option value="fp">Father's phone</option>
                            <option value="mp">Mother's phone</option>
                </select>    


            </template>
            <template v-slot:buttons>
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="newCourse()" ><p class="flex text-center text-white pl-[20%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
         </svg>&nbsp;&nbsp;<font class='pt-1'>Assign course</font> </p></button>
    
 </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { coursesStore } from '../../stores/courses'
import { useUserStore } from '../../stores/auth'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations,onlyNumberKey} from "../../helpers/validations"
import {generateKey} from '../../helpers/generate_key'


export default {
      name:"assignNewCourse",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const coursesstores = coursesStore()
        const userStore = useUserStore()
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)      

        const formData = ref({
            course_name:"",
            school_id:"",
            course_id:generateKey(5)
        });

        const rules = ref({
            course_name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
        });

        const messages = ref({
            course_name:{
                required:"Course name field is required",
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
            errorFeedbackStatus.value = coursesstores.errorMessage != "" ? false : true
            successFeedbackStatus.value = coursesstores.successMessage != "" ? false : true
            return coursesstores.loadingUI
        });

        const errorStatus = computed(() => {
            return coursesstores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            formData.value.course_name=""
            return coursesstores.successMessage
        });

        function newCourse(){
            if(validate(messages.value,rules.value,formData.value))
            {
                return coursesstores.createNewCourse(formData.value)
            }
         }

        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                },1000);
            }
         })
        
        return {messages,rules,formData,slotData,getClassroomList,loadingStatus,validate,errorStatus,successStatus,newCourse,closeFeedback,successFeedbackStatus,errorFeedbackStatus}
       },
    }
    </script>

    