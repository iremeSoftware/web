<template>
    <ModalPopUp height="250">
        <template v-slot:title>
            Create new classroom
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

                <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" :message="errorStatus.error.classroom_name  == 'add_new_class_Modal.class_room_exist' ? 'Classroom you entered is already exists' : ''

 ?? errorStatus.error " type="danger" :closeMethod="closeFeedback"/>


                <p class="text-sm font-semibold text-left">Classroom Name: <span class=" text-red-600" title="Required field">(*)</span></p>
                <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter classroom name here' v-model="formData.classroom_name" id="formData.classroom_name" />
                <span class="text-end text-red-600 text-xs" >{{messages.classroom_name.slot}}</span>

                <p class="text-sm font-semibold text-left">Classroom Alias:</p>
                <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter classroom alias' v-model="formData.classroom_alias" id="formData.classroom_alias" />         
            </template>
            <template v-slot:buttons>
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="newClassroom()" ><p class="flex text-center text-white pl-[20%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
         </svg>&nbsp;&nbsp;<font class='pt-1'>Create new</font></p></button>
    
 </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { classroomStore } from '../../stores/classroom'
import { useUserStore } from '../../stores/auth'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations,onlyNumberKey} from "../../helpers/validations"
import {generateKey} from '../../helpers/generate_key'


export default {
      name:"createClassroomModal",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const classroomstores = classroomStore()
        const userStore = useUserStore()
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)      

        const formData = ref({
            classroom_name:"",
            classroom_alias: "",
            school_id:"",
            classroom_representative:"empty",
            class_id:generateKey(5)
        });

        const rules = ref({
            classroom_name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
        });

        const messages = ref({
            classroom_name:{
                required:"Classroom name field is required",
                slot:"",
                className:""
            },
        });

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        const getClassroomList = computed(() => {
            return classroomstores.classroomList.classrooms;
        });

        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = classroomstores.errorMessage != "" ? false : true
            successFeedbackStatus.value = classroomstores.successMessage != "" ? false : true
            return classroomstores.loadingUI
        });

        const errorStatus = computed(() => {
            return classroomstores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            formData.value.classroom_name=""
            formData.value.classroom_alias=""
            return classroomstores.successMessage
        });

        function newClassroom(){
            if(validate(messages.value,rules.value,formData.value))
            {
                return classroomstores.createNewClassroom(formData.value)
            }
         }

        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                },2000);
            }
         })
        
        return {messages,rules,formData,slotData,getClassroomList,loadingStatus,validate,errorStatus,successStatus,newClassroom,closeFeedback,successFeedbackStatus,errorFeedbackStatus}
       },
    }
    </script>

    