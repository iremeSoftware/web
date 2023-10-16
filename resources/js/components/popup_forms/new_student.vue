<template>
<ModalPopUp>
    <template v-slot:title>
         Create new student
</template>
<template v-slot:contents>
    
    <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter student names' v-model="formData.name" id="formData.name" />
        <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.name.slot}}</span>
        </div>


    <p class="pt-2 text-sm font-semibold text-left">Select student sex: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='student_sex' class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.student_sex"  v-model="formData.student_sex"  >
                      <option value=''>Select student sex</option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
        </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.student_sex.slot}}</span>
                      </div>


    <p class="pt-2 text-sm font-semibold text-left">Select classroom: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='classroom' class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.classroom"  v-model="formData.classroom"  >
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
         <select @change='validate(messages,rules,formData,$event)'  name='priority_phone' class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.priority_phone"  v-model="formData.priority_phone"  >
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
          <input type='number' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" maxlength=16 minlength=16  placeholder="Enter father's ID No" v-model="formData.fathers_ID" id="formData.fathers_ID" />

    <p class="pt-2 text-sm font-semibold text-left">Mother's ID No:</p>
          <input type='number' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter mother's ID No" maxlength=16 minlength=16 v-model="formData.mothers_ID" id="formData.mothers_ID" />


    <p class="pt-2 text-sm font-semibold text-left">Select location district:</p>
         <select @change='display_sectors($event)'  name='location_district' class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.location_district"  v-model="formData.location_district"  >
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>

    <p class="pt-2 text-sm font-semibold text-left">Select location sector:</p>
          <select name='location_sector' class="w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.location_sector" id="formData.location_sector">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>

    <p class="pt-2 text-sm font-semibold text-left">Enter location cell:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter location cell" v-model="formData.location_cell" id="formData.location_cell" />

          <p class="pt-2 text-sm font-semibold text-left">Enter location village:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter location village" v-model="formData.location_village" id="formData.location_village" />    
        
</template>
<template v-slot:buttons>
    <button  class="w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="createStudent()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
            <svg  v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-1 mr-1 h-5 w-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
</svg>Register student

</p>

          </button> </template>
</ModalPopUp>
</template>


<script>
import { ref, useSlots,computed, onMounted } from 'vue'
import { uiChangesStore } from '../../stores/ui_changes'
import { classroomStore } from '../../stores/classroom'
import { useUserStore } from '../../stores/auth'
import districtsList from "../../data/districts.json"
import sectors from '../../data/sectors.json'


import ModalPopUp from './../ModalPopUp.vue'
import {validations} from "../../helpers/validations"


    
    export default {
      name:"newStudentForm",
     components:{
      ModalPopUp,
   },
      setup() {
        const slots = useSlots()
        const slotData = ref(slots)
        const uiStore = uiChangesStore()
        const classroomstore = classroomStore()
        const userStore = useUserStore();
        const isPopUpOpened = computed(() => uiStore.isPopUpOpened)
        const feedbackStatus = ref(false)
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
            location_district:"",
            location_sector:"",
            location_cell:"",
            location_sector:""
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
                validationClass:"ring-1 ring-red-500",
            },       
            mothers_phone:{
                required:true,
                validationClass:"ring-1 ring-red-500",
            },
            priority_phone:{
                required:true,
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
                slot:"",
                className:""
            },
            mothers_phone:{
                required:"Please enter mother's phone",
                slot:"",
                className:""
            },
            priority_phone:{
                required:"Please select priority phone",
                slot:"",
                className:""
            },
        });

        function display_sectors(){
          sector.value=sectors[event.target.value];
        }

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        function createStudent(){
            if(validate(messages.value,rules.value,formData.value))
            {
                return store.complete_registration(formData.value);
            }
        }


        const loadingStatus = computed(() => {
        feedbackStatus.value = classroomstore.errorMessage != "" ? false : true
        return classroomstore.loadingUI
        });

        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        const getClassroomList = computed(() => {
            return classroomstore.classroomList.classrooms;
        });
        onMounted(() => {
            districts.value = districtsList
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    classroomstore.getClassroomList(userStore.userDetails.school_id)
                },2000);
            }
        });
        return {messages,formData,rules,slotData,isPopUpOpened,showPopUp,createStudent,validate,loadingStatus,getClassroomList,districts,sector,display_sectors}
       },
    }
    </script>