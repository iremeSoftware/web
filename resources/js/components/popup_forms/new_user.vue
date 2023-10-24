<template>

<ModalPopUp >
    
<template v-slot:title>
         Invite new user
</template>
<template v-slot:contents>

    <Alert v-if="successStatus !='' && feedbackStatus == false " :message="successStatus == 'success' ? `Invitation is successfully sent ${usersList.email}`:''"  type="success" :closeMethod="closeFeedback"/>

    <Alert v-if="successMessageMap !='' && successFeedbackStatus == false" :message="successMessageMap.inserted == 0 ?'No records imported':`(${successMessageMap.inserted}) Records are successfully imported`"  type="success" :closeMethod="closeFeedback"/>

    
    <Alert  v-if="errorStatus !='' && errorFeedbackStatus == false" 
      :message="errorStatus.data.message == 'message.email_is_not_valid' ? 'Email found on document is not valid':errorStatus.data.message" 
       type="danger" :closeMethod="closeFeedback"/>

<div class="absolute w-full -mt-6 -ml-6 border-b border-gray-200 dark:border-gray-700 bg-white">

    <ul class="flex flex-wrap  -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400" >
        <li class="md:w-[50%] mr-2" @click="selectTab()">
            <a href="#" class="inline-flex text-black border-black items-center justify-center p-4 border-b-[3px]  rounded-t-lg  dark:text-blue-500 dark:border-blue-500 group" :class="isCSVTabSelected?'text-gray-500 border-gray-200 ':''" aria-current="page">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
                </svg>
                &nbsp;&nbsp;Fill the form
            </a>
        </li>
        <li class="mr-2" @click="selectTab()">
            <a href="#" class="inline-flex items-center justify-center p-4 border-b-[3px]  rounded-t-lg group" :class="isCSVTabSelected?'text-black border-black border-b-[3px]':''" aria-current="page">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
            </svg>&nbsp;&nbsp;Import users from CSV
            </a>
        </li>
    </ul>
</div>

<div class="space-y-4" :class="isCSVTabSelected?'hidden':'block'">
    <p class="pt-12 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter user names' v-model="formData.name" id="formData.name" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.name.slot}}</span>
        </div>

    <p class="pt-2 text-sm font-semibold text-left">User email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter user's email" v-model="formData.email" id="formData.email" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.email.slot}}</span>
    </div> 

    <p class="pt-2 text-sm font-semibold text-left">User phone number: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter user's phone number" v-model="formData.phone_number" id="formData.phone_number" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.phone_number.slot}}</span>
        </div>

    <p class="pt-2 text-sm font-semibold text-left">Select user role:  <span class=" text-red-600" title="Required field">(*)</span></p>
        <select @change='validate(messages,rules,formData,$event)'  name='select_user_role' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.select_user_role"  v-model="formData.select_user_role"  >
            <option value="">Select user role</option>
            <option>Teacher</option>
            <option>Director</option>
            <option>Bursar</option>
            <option>Patron</option>
            <option>Matron</option>
            <option>DOS</option>
        </select>
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.select_user_role.slot}}</span>
        </div>    
        
        <input type="hidden" v-model="formData.school_id">
        </div>


        <div class="space-y-3" :class="isCSVTabSelected?'block':'hidden'">
            <main>
<section class="section-container min-h-1/2">
  <div class="flex flex-col items-center">
    <div class="mt-6 py-3 bg-white rounded-lg w-full">

      <!-- Documents uploads form and instructions -->
      <section class="mt-5 px-3 flex gap-6 " @dragover="dragover"
      @dragleave="dragleave" @drop="drop">
        <div class="flex-1 flex flex-col items-center p-3 border-2 border-dotted border-gray-300 rounded-lg drag-area" :class="files.length >0 ? 'border-[#000000] border-4':'border-2'">
        <i class="fa-sharp fa-solid fa-cloud-arrow-up text-6xl text-violet-400"></i>
          <header class="mt-6" v-if="files.length ==0">
            <span class="drag-file">Drag file here to upload </span> or
            
            <input type="file" multiple name="file" id="fileInput" class="" @change="onChange" ref="file" accept=".csv" />
        
            from your device

            <p class="mt-12 text-red-400 text-sm">
            Only CSV files allowed
          </p>
          </header>
          <header v-else>
            <p>{{ files.name }}</p>
             <div class="w-full ">
                <button  class="w-44 mt-10 pl-10    h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="clearUpload()" ><p class="flex text-center text-white pl-[10%]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>&nbsp;&nbsp;Clear</p></button>
             </div>
          </header>
          <input type="file" class="file-input" hidden />
        </div>
      </section>

      <p class="flex text-xs pl-3 pt-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
        </svg>&nbsp;&nbsp;Please download this&nbsp;<a href="/documents/import_users.csv" class="text-blue-500">CSV template </a>&nbsp;for a reference, also ensure that all the records are valid</p>

    </div>
  </div>
</section>
</main>
</div>
        
</template>


    <template v-slot:buttons>
    <div v-if="isCSVTabSelected==false">
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[25%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="createNewUser()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
         <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
         </svg>&nbsp;&nbsp;<font class='pt-1'>Invite user</font></p></button>
    </div>
    <div v-else>
    <button :disabled="loadingStatus.isLoading"  class="w-full pl-[30%] md:pl-0 md:w-[20%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="importUsers()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
          <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
            </svg>&nbsp;&nbsp;
            <font class='pt-1'>Import</font></p></button>
    </div>
 </template>



</ModalPopUp>


</template>


<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { uiChangesStore } from '../../stores/ui_changes'
import { useUserStore } from '../../stores/auth'
import { manageUserStore } from '../../stores/users'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations,onlyNumberKey} from "../../helpers/validations"


export default {
      name:"newUserModal",
      components:{
      ModalPopUp,
      Alert
      },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const uiStore = uiChangesStore()
        const userStore = useUserStore()
        const manageUsersStore = manageUserStore()
        const isPopUpOpened = computed(() => uiStore.isPopUpOpened)
        const feedbackStatus = ref(false);
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)      
        const formData = ref({
            name:"",
            email: "",
            phone_number:"",
            select_user_role:"",
            registered_by:""
        });

        const rules = ref({
            name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            email:{
                email:true,
                validationClass:"ring-1 ring-red-500",
            },
            phone_number:{
                required:true,
                maxlength:10,
                counter:true,
                validationClass:"ring-1 ring-red-500",
            },
            select_user_role:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
        });

        const messages = ref({
            name:{
                required:"Please fill in user's names",
                slot:"",
                className:""
            },
            email:{
                email:"Please enter valid email",
                slot:"",
                className:""
            },
            phone_number:{
                required:"Please enter user's phone number",
                counter:"$count out of $maxlength digits",
                slot:"",
                className:""
            },
            select_user_role:{
                required:"Please select user role below",
                slot:"",
                className:""
            },
        });

        const isCSVTabSelected = ref(false)
        const isDragging = ref(false)
        const files = ref([])

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        function createNewUser(){
            if(validate(messages.value,rules.value,formData.value))
            {
                return manageUsersStore.createNewUser(formData.value)
            }
        }

        function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }


        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = manageUsersStore.errorMessage != "" ? false : true
            successFeedbackStatus.value = manageUsersStore.successMessageArr != "" ? false : true
            return manageUsersStore.loadingUI
        });

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        const errorStatus = computed(() => {
            clearUpload()
            errorFeedbackStatus.value = manageUsersStore.errorMessage != "" ? false : true
            return manageUsersStore.errorMessage
        });

        const successMessageMap = computed(() => {
            clearUpload()
            return manageUsersStore.successMessageArr
        })

        const usersList = computed(() => {
            return manageUsersStore.usersList
        })

        const successStatus = computed(() => {
            formData.value.name=""
            formData.value.email=""
            formData.value.phone_number= ""
            formData.value.select_user_role= ""
            return manageUsersStore.successMessage
        });

        function selectTab(){
            isCSVTabSelected.value =! isCSVTabSelected.value

        }

        function onChange(e) {
            if(e.target.files[0].type !='text/csv')
            {
                alert('Only CSV file allowed')
            }
            else {
                console.log(e.target.files[0])
                files.value = e.target.files[0]
            }
         } 

         function dragover(e) {
            e.preventDefault()
            isDragging.value = true;
         }
            
         function dragleave() {
            isDragging.value = false;
         }

        function drop(e) {
            if(e.dataTransfer.files[0].type !='text/csv')
            {
                alert('Only CSV file allowed')
            }
            else {
                files.value = e.dataTransfer.files[0]
                console.log(files.value);
                isDragging.value = false
            }
        }

        function clearUpload(){
            files.value = []
        }

        function importUsers(){
            if(files.value=="")
            {
                alert('CSV file are required')
                return false
            }
            let frmData= new FormData()
            frmData.append('file',files.value)
            const datas = {
                'school_id':userStore.userDetails.school_id,
                'class_id':formData.value.classroom
            }
            return manageUsersStore.importUsersCSV(datas,frmData)
           }


        onMounted(() => {
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    formData.value.school_id = userStore.userDetails.school_id
                    formData.value.registered_by = userStore.userDetails.account_id
                },1000);
            }
        });
        return {messages,formData,rules,slotData,isPopUpOpened,showPopUp,createNewUser,validate,loadingStatus,closeFeedback,feedbackStatus,successFeedbackStatus,errorFeedbackStatus,successStatus,onlyNumberKey,errorStatus,selectTab,isCSVTabSelected,files,dragover,dragleave,drop,onChange,clearUpload,importUsers,successMessageMap,usersList}
       },
    }
    </script>

    