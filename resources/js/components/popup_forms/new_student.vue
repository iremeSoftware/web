<template>

<ModalPopUp >
    
<template v-slot:title>

         Create new student
</template>
<template v-slot:contents>

    <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

    <Alert v-if="successMessageMap !='' && successFeedbackStatus == false" :message="successMessageMap.inserted == 0 ?'No records imported':`(${successMessageMap.inserted}) Records are successfully imported`"  type="success" :closeMethod="closeFeedback"/>

    
    <Alert  v-if="errorStatus !='' && feedbackStatus == false" 
      :message="
      errorStatus.message ?? 
      (
      errorStatus.errors 
      ? errorStatus.errors.password_confirmation 
      :
       (errorStatus.password !=undefined ? errorStatus.password[0] +'<br>' : '') + 
       (errorStatus.password_confirmation !=undefined ? errorStatus.password_confirmation[0] +'<br>' : '') + 
       (errorStatus.email !=undefined ? errorStatus.email[0] +'<br>' : '') + 
       (errorStatus.phone_number !=undefined ? errorStatus.phone_number[0] : '')
       )" 
       
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
            </svg>&nbsp;&nbsp;Import from CSV file
            </a>
        </li>
    </ul>
</div>

<div class="space-y-4" :class="isCSVTabSelected?'hidden':'block'">
    <p class="pt-12 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter student names' v-model="formData.name" id="formData.name" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.name.slot}}</span>
        </div>


    <p class="pt-2 text-sm font-semibold text-left">Select student sex: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='student_sex' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.student_sex"  v-model="formData.student_sex"  >
                      <option value=''>Select student sex</option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
        </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.student_sex.slot}}</span>
                      </div>


    <p class="pt-2 text-sm font-semibold text-left">Select classroom: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='classroom' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.classroom"  v-model="formData.classroom"  >
                      <option value=''>Select classroom</option>
                      <option v-for="a in getClassroomList" :value="a.class_id" :key="a.class_id">{{a.classroom_name}}</option>
        </select>
                      <div class="text-end">
                      <span class="text-red-600 text-xs" >{{messages.classroom.slot}}</span>
                      </div>

    <p class="pt-2 text-sm font-semibold text-left">Father's name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter father's name" v-model="formData.fathers_name" id="formData.fathers_name" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.fathers_name.slot}}</span>
        </div> 
        
    <p class="pt-2 text-sm font-semibold text-left">Mother's name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter mother's name" v-model="formData.mothers_name" id="formData.mothers_name" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.mothers_name.slot}}</span>
        </div>   
    <p class="pt-2 text-sm font-semibold text-left">Father's phone:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter father's phone" v-model="formData.fathers_phone" id="formData.fathers_phone" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.fathers_phone.slot}}</span>
        </div> 
    <p class="pt-2 text-sm font-semibold text-left">Mother's phone:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter mother's phone" v-model="formData.mothers_phone" id="formData.mothers_phone" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.mothers_phone.slot}}</span>
        </div>   
    <p class="pt-2 text-sm font-semibold text-left">Select priority phone: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='priority_phone' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.priority_phone"  v-model="formData.priority_phone"  >
                      <option value=''>Select priority phone</option>
                      <option value="fp">Father's phone</option>
                      <option value="mp">Mother's phone</option>
        </select>
        <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.student_sex.slot}}</span>
                      </div> 
    <p class="pt-2 text-sm font-semibold text-left">Parent email:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter parent email" v-model="formData.parent_email" id="formData.parent_email" />
          
    <p class="pt-2 text-sm font-semibold text-left">Father's ID No:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" 
           maxlength=16 minlength=16  placeholder="Enter father's ID No" v-model="formData.fathers_ID" id="formData.fathers_ID" />
          <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.fathers_ID.slot}}</span>
          </div> 

    <p class="pt-2 text-sm font-semibold text-left">Mother's ID No:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter mother's ID No" maxlength=16 minlength=16 v-model="formData.mothers_ID" id="formData.mothers_ID" />
          <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.mothers_ID.slot}}</span>
          </div> 


    <p class="pt-2 text-sm font-semibold text-left">Select location district:</p>
         <select @change='display_sectors($event)'  name='location_district' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.location_district"  v-model="formData.location_district"  >
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>

    <p class="pt-2 text-sm font-semibold text-left">Select location sector:</p>
          <select name='location_sector' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.location_sector" id="formData.location_sector">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>

    <p class="pt-2 text-sm font-semibold text-left">Enter location cell:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter location cell" v-model="formData.location_cell" id="formData.location_cell" />

          <p class="pt-2 text-sm font-semibold text-left">Enter location village:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter location village" v-model="formData.location_village" id="formData.location_village" />    
        <input type="hidden" v-model="formData.school_id">
        </div>


        <div class="space-y-3" :class="isCSVTabSelected?'block':'hidden'">
            <main>
<section class="section-container min-h-1/2">
  <div class="flex flex-col items-center">
    <div class="mt-6 py-3 bg-white rounded-lg w-full">

        <p class="pt-2 text-sm font-semibold text-left">Select classroom: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='classroom' class="mt-4 w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.classroom"  v-model="formData.classroom"  >
                      <option value=''>Select classroom</option>
                      <option v-for="a in getClassroomList" :value="a.class_id" :key="a.class_id">{{a.classroom_name}}</option>
        </select>
        <div class="text-end">
        <span class="text-red-600 text-xs" >{{messages.classroom.slot}}</span>
        </div>

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
        </svg>&nbsp;&nbsp;Please download this&nbsp;<a href="/documents/import_students.csv" class="text-blue-500">CSV template </a>&nbsp;for a reference, also ensure that all the records are valid</p>

    </div>
  </div>
</section>
</main>
</div>
        
</template>


    <template v-slot:buttons>
    <div v-if="isCSVTabSelected==false">
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="createStudent()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
            <svg  v-if="loadingStatus.isLoading == false"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-1 mr-1 h-5 w-5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
    </svg> &nbsp;&nbsp;<font class='pt-1'>Register student</font></p></button>
    </div>
    <div v-else>
    <button :disabled="loadingStatus.isLoading"  class="w-full pl-[30%] md:pl-0 md:w-[20%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="importStudent()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
          <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
            </svg>&nbsp;&nbsp;
             Import</p></button>
    </div>
 </template>



</ModalPopUp>


</template>


<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { uiChangesStore } from '../../stores/ui_changes'
import { classroomStore } from '../../stores/classroom'
import { useUserStore } from '../../stores/auth'
import { studentsStore } from '../../stores/students'
import districtsList from "../../data/districts.json"
import sectors from '../../data/sectors.json'
import Alert from '../../components/alert.vue'
import ModalPopUp from './../ModalPopUp.vue'
import {validations,onlyNumberKey} from "../../helpers/validations"
import {generateKey} from '../../helpers/generate_key'


export default {
      name:"newStudentForm",
      components:{
      ModalPopUp,
      Alert
      },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const uiStore = uiChangesStore()
        const classroomstore = classroomStore()
        const userStore = useUserStore()
        const studentsStores = studentsStore()
        const isPopUpOpened = computed(() => uiStore.isPopUpOpened)
        const feedbackStatus = ref(false);
        const successFeedbackStatus = ref(false)
        const errorFeedbackStatus = ref(false)      
        const districts = ref([])
        const sector = ref([])
        const formData = ref({
            name:"",
            student_sex: "",
            classroom:"",
            fathers_name: "",
            mothers_name:"",
            fathers_phone: "",
            mothers_phone: "",
            priority_phone: "",
            parent_email:"",
            fathers_ID:"",
            mothers_ID:"",
            location_district:"",
            location_sector:"",
            location_cell:"",
            school_id:"",
            student_id:generateKey(10),
            registered_by:""
        });

        const rules = ref({
            name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            student_sex:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            classroom:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            fathers_name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            mothers_name:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            fathers_phone:{
                required:true,
                maxlength:10,
                counter:true,
                validationClass:"ring-1 ring-red-500",
            },       
            mothers_phone:{
                required:true,
                maxlength:10,
                counter:true,
                validationClass:"ring-1 ring-red-500",
            },
            priority_phone:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            fathers_ID:{
                maxlength:16,
                counter:true,
                validationClass:"ring-1 ring-red-500",
            },
            mothers_ID:{
                maxlength:16,
                counter:true,
                validationClass:"ring-1 ring-red-500",
            }
        });

        const messages = ref({
            name:{
                required:"Students names are required",
                slot:"",
                className:""
            },
            student_sex:{
                required:"Please select student sex",
                slot:"",
                className:""
            },
            classroom:{
                required:"Please select classroom",
                slot:"",
                className:""
            },
            fathers_name:{
                required:"Please enter father's name",
                slot:"",
                className:""
            },
            mothers_name:{
                required:"Please enter mother's name",
                slot:"",
                className:""
            },
            fathers_phone:{
                required:"Please enter father's phone",
                counter:"$count out of $maxlength digits",
                slot:"",
                className:""
            },
            mothers_phone:{
                required:"Please enter mother's phone",
                counter:"$count out of $maxlength digits",
                slot:"",
                className:""
            },
            priority_phone:{
                required:"Please select priority phone",
                slot:"",
                className:""
            },
            fathers_ID:{
                counter:"$count / $maxlength digits",
                slot:"",
                className:""
            },
            mothers_ID:{
                counter:"$count / $maxlength digits",
                slot:"",
                className:""
            },
        });

        const isCSVTabSelected = ref(false)
        const isDragging = ref(false)
        const files = ref([])

        function display_sectors(){
          sector.value=sectors[event.target.value];
        }

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        function createStudent(){
            if(validate(messages.value,rules.value,formData.value))
            {
                return studentsStores.createStudent(formData.value)
            }
        }

        function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }


        const loadingStatus = computed(() => {
            errorFeedbackStatus.value = studentsStores.errorMessage != "" ? false : true
            successFeedbackStatus.value = studentsStores.successMessageArr != "" ? false : true
            return studentsStores.loadingUI
        });

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        const getClassroomList = computed(() => {
            return classroomstore.classroomList.classrooms;
        });

        const errorStatus = computed(() => {
            clearUpload()
            return studentsStores.errorMessage
        });

        const successMessageMap = computed(() => {
            clearUpload()
            return studentsStores.successMessageArr
        })

        const successStatus = computed(() => {
            formData.value.name=""
            formData.value.student_sex=""
            formData.value.classroom= "",
            formData.value.fathers_name=""
            formData.value.mothers_name=""
            formData.value.fathers_phone=""
            formData.value.mothers_phone=""
            formData.value.priority_phone=""
            formData.value.school_phone_number=""
            formData.value.parent_email=""
            formData.value.fathers_ID=""
            formData.value.mothers_ID=""
            formData.value.location_district=""
            formData.value.location_sector=""
            formData.value.location_cell=""
            formData.value.location_cell=""
            return studentsStores.successMessage
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

        function importStudent(){
            if(formData.value.classroom=="" || files.value=="")
            {
                alert('Classroom & CSV file are required')
                return false
            }
            let frmData= new FormData()
            frmData.append('file',files.value)
            const datas = {
                'school_id':userStore.userDetails.school_id,
                'class_id':formData.value.classroom
            }
            return studentsStores.importStudents(datas,frmData)
           }


        onMounted(() => {
            districts.value = districtsList
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    classroomstore.getClassroomList(userStore.userDetails.school_id)
                    formData.value.school_id = userStore.userDetails.school_id
                    formData.value.registered_by = userStore.userDetails.account_id
                },1000);
            }
        });
        return {messages,formData,rules,slotData,isPopUpOpened,showPopUp,createStudent,validate,loadingStatus,getClassroomList,districts,sector,display_sectors,closeFeedback,feedbackStatus,successFeedbackStatus,errorFeedbackStatus,successStatus,onlyNumberKey,errorStatus,selectTab,isCSVTabSelected,files,dragover,dragleave,drop,onChange,clearUpload,importStudent,successMessageMap}
       },
    }
    </script>

    