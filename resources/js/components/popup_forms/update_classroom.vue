<template>
    <ModalPopUp height="400">
        <template v-slot:title>
            Update class details
          
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>
                
                <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" :message="errorStatus" type="danger" :closeMethod="closeFeedback"/>
                 
                {{ popupDetails.classroom_representative }}

                <p class="pt-2 text-sm font-semibold text-left">Classroom name: <span class=" text-red-600" title="Required field">(*)</span></p>
                <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter class name" v-model="formData.classroom_name" id="formData.classroom_name" />
                <div class="text-end">
                <span class="  text-red-600 text-xs" >{{messages.classroom_name.slot}}</span>
                </div>

                <p class="pt-2 text-sm font-semibold text-left">Classroom alias: </p>
                <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter classroom alias" v-model="formData.classroom_alias" id="formData.classroom_alias" />

                <p class="pt-2 text-sm font-semibold text-left">Select class representative:</p>
                <select @change='validate(messages,rules,formData,$event)'  name='teacher_id' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.classroom_representative"  v-model="formData.classroom_representative"  >
                    <option value=''>Select user</option>
                    <option v-for="user in getUsersList" :value="user.account_id">{{ user.name }}</option>
                </select>  


            </template>
            <template v-slot:buttons>
        <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="updateClassroom()" ><p class="flex text-center text-white pl-[20%]">
            <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
          &nbsp;&nbsp;<font class='pt-1'>Update</font> </p></button>
 </template>
    </ModalPopUp>
</template>

<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { useUserStore } from '../../stores/auth'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations} from "../../helpers/validations"
import { uiChangesStore } from '../../stores/ui_changes'
import { manageUserStore } from '../../stores/users'
import { classroomStore } from '../../stores/classroom'


export default {
      name:"updateClassroomPopup",
      components:{
      ModalPopUp,
      Alert
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const userStore = useUserStore()
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)   
        const uiStore = uiChangesStore();
        const manageUsers = manageUserStore()
        const classroomStores = classroomStore()



        const popupDetails = computed(() => uiStore.popupDetails)

    
        const formData = ref({
            class_id:uiStore.popupDetails.popup_data.class_id ?? "",
            classroom_name:uiStore.popupDetails.popup_data.classroom_name ?? "",
            classroom_alias:uiStore.popupDetails.popup_data.classroom_alias ?? "",
            classroom_representative:uiStore.popupDetails.popup_data.classroom_representative ?? "",
            school_id:userStore.userDetails.school_id,
        });

        const rules = ref({
            classroom_name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
        });

        const messages = ref({
            classroom_name:{
                required:"Classroom name is required",
                slot:"",
                className:""
            },
        });

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = classroomStores.errorMessage != "" ? false : true
            successFeedbackStatus.value = classroomStores.successMessage != "" ? false : true
            return classroomStores.loadingUI
        });
        const errorStatus = computed(() => {
            return classroomStores.errorMessage
        });

        function closeFeedback() {
            successFeedbackStatus.value =! successFeedbackStatus.value
            errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            return classroomStores.successMessage
        });

        const getUsersList = computed(() => {
            return getUniqueListBy(manageUsers.usersList, 'account_id')
        });

        function getUniqueListBy(arr, key) {
            return [...new Map(arr.map(item => [item[key], item])).values()]
        }
        


        function updateClassroom(){
            if(validate(messages.value,rules.value,formData.value))
            {
               let school_id = formData.value.school_id
               return classroomStores.updateClassroom(school_id,formData.value)
            }
        }

        function schoolUsers(school_id){
            return manageUsers.getSchoolUsers(school_id)
        }



        onMounted(() => {
            if(userStore.getUserData())
            {
                successFeedbackStatus.value = true
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                    schoolUsers(formData.value.school_id)
                },1000);
            }
         })
        
        return {messages,rules,formData,slotData,loadingStatus,validate,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,updateClassroom,popupDetails,getUsersList}
       },
    }
    </script>

    