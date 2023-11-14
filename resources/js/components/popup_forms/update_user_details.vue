<template>
    <ModalPopUp height="550">
        <template v-slot:title>
            Update user details ({{ popupDetails.popup_data.name }})
          
            </template>
            <template v-slot:contents>

                <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>
                
                <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" :message="errorStatus" type="danger" :closeMethod="closeFeedback"/>
               <p class="text-md font-bold">Tick user's authentication below</p>
                <div class="w-full">
                    <div class="ml-2" v-for="auth,key in authenticationsList" :key="auth.key">
                        <input type="checkbox" v-model="auths" :value="auth.key"  :id="auth.key" :disabled="formData.school_representative == formData.account_id && auth.key == 'edit_school_settings'" />
                        <label class="ml-2 font-semibold text-sm" :for="auth.key">{{ auth.value }}</label>
                    </div>
                </div>
                <p class="pt-2 text-sm font-semibold text-left">Change user status:</p>
                <select @change='validate(messages,rules,formData,$event)'  name='teacher_id' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.account_enabled"  v-model="formData.account_enabled"  >
                    <option value=''>Select account status</option>
                    <option value="0">Not Verified</option>
                    <option value="1">Active</option>
                    <option value="2">Disable</option>
                </select>  
            </template>
            <template v-slot:buttons>
        <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="updateUserAuth()" ><p class="flex text-center text-white pl-[20%]">
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
      name:"updateUserPopup",
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
            authentications:uiStore.popupDetails.popup_data.authentications ?? "",
            account_enabled:uiStore.popupDetails.popup_data.account_enabled ?? "",
            account_id:uiStore.popupDetails.popup_data.account_id ?? "",
            school_representative:userStore.userDetails.school_representative ?? "",
            school_id:userStore.userDetails.school_id,

        });

        const authenticationsList = ref([
            {
            key:'add_classroom',
            value:'Manage Classroom'
            },
            {
            key:'add_course',
            value:'Manage Courses'
            },
            {
            key:'generate_report',
            value:"Generate Report Form"
            },
            {
            key:'teacher',
            value:"Teacher"
            },
            {
            key:'add_new_users',
            value:"Invite New Users"
            },
            {
            key:'send_sms',
            value:"Send SMS"
            },
            {
            key:'pay_license',
            value:"Pay License"
            },
            {
            key:'manage_students',
            value:"Manage Students"
            },
            {
            key:'edit_conduct_marks',
            value:"Edit Behavior Marks"
            },
            {
            key:'edit_student_attendance',
            value:"Manage Student Attendance"
            },
            {
            key:'access_lms',
            value:"Manage Library Management System"
            },
            {
            key:'edit_school_settings',
            value:"Manage Users"
            },
            {
            key:'access_file_manager',
            value:"Manage Cloud Storage"
            },
            {
            key:'manage_reports',
            value:"Manage Reports"
            }
        ]);

        const auths = ref([])

        const rules = ref({

        });

        const messages = ref({

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
        


        function updateUserAuth(){
            if(validate(messages.value,rules.value,formData.value))
            {
                let data = {
                    'authentications':auths.value.toString(),
                    'account_enabled':formData.value.account_enabled,
                    'account_id':formData.value.account_id
                }
                uiStore.openPopUpFunc() // Close popup
               return manageUsers.updateUsersAuthentications(data)
            } 
        }

        function getSelectedAuths(){
            let selectedOptions = formData.value.authentications
            for(var i=0; i<=authenticationsList.value.length-1;i++)
            {
                // School admin have a full access on the school_settings
               if(formData.value.school_representative == formData.value.account_id && authenticationsList.value[i].key == 'edit_school_settings')
               {
                 auths.value[i] = 'edit_school_settings'
               }

               if(selectedOptions.includes(authenticationsList.value[i].key))
                   auths.value[i] = authenticationsList.value[i].key
            }
        }


        onMounted(() => {
            if(userStore.getUserData())
            {
                getSelectedAuths()
                successFeedbackStatus.value = true
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                },1000);
            }
         })
        
        return {messages,rules,formData,slotData,loadingStatus,validate,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,popupDetails,getUsersList,authenticationsList,updateUserAuth,auths}
       },
    }
    </script>

    