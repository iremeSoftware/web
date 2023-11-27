<template>

<ModalPopUp >
    
<template v-slot:title>

         Update records of {{ popUpDetails.name }}
</template>
<template v-slot:contents>

    <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus == 'success' ? 'Student records are successfully updated':successStatus"  type="success" :closeMethod="closeFeedback"/>

    
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



<div class="space-y-4">
    <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
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
                      <span class="  text-red-600 text-xs" >{{messages.priority_phone.slot}}</span>
                      </div> 
    <p class="pt-2 text-sm font-semibold text-left">Parent email:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter parent email" v-model="formData.parent_email" id="formData.parent_email" />
          
    <p class="pt-2 text-sm font-semibold text-left">Father's ID No:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" 
           maxlength=16  placeholder="Enter father's ID No" v-model="formData.fathers_ID" id="formData.fathers_ID" />
          <!-- <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.fathers_ID.slot}}</span>
          </div>  -->

    <p class="pt-2 text-sm font-semibold text-left">Mother's ID No:</p>
          <input type='text' class='w-full h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder="Enter mother's ID No" maxlength=16 v-model="formData.mothers_ID" id="formData.mothers_ID" />
          <!-- <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.mothers_ID.slot}}</span>
          </div>  -->


          <p class="pt-2 text-sm font-semibold text-left">Select location province :</p>
    <select @change='display_districts($event)'  name='location_province' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.location_province"  v-model="formData.location_province"  >
                <option value=''>Select provinces</option>
                <option v-for="a,k in locations.provinces" :value="k+'_'+a.name" :key="a.name">{{a.name}} </option>
                </select>      


    <p class="pt-2 text-sm font-semibold text-left">Select location district:</p>
         <select @change='display_sectors($event)'  name='location_district' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.location_district"  v-model="formData.location_district"  >
                      <option value=''>Select district</option>
                      <option v-for="a,k in districts" :value="k+'_'+a.name" :key="a.name">{{a.name}} </option>
                      </select>

    <p class="pt-2 text-sm font-semibold text-left">Select location sector:</p>
          <select @change='display_cells($event)' name='location_sector' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.location_sector" id="formData.location_sector">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a,k in sector" v-bind:value="k+'_'+a.name" :key="k+'_'+a.name">{{a.name}} </option>
                      </select>


    <p class="pt-2 text-sm font-semibold text-left">Select location cell:</p>
          <select @change="display_villages($event)" name='location_sector' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.location_cell" id="formData.location_cell">
                      <option value=''>Select location cell:</option>
                      <option  v-for="a,k in cell" v-bind:value="k+'_'+a.name" :key="k+'_'+a.name">{{a.name}} </option>
                      </select>  
                      

    <p class="pt-2 text-sm font-semibold text-left">Select location village:</p>
          <select name='location_sector' class="w-full h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.location_village" id="formData.location_village">
                      <option value=''>Select location village:</option>
                      <option  v-for="a,k in villages" v-bind:value="k+'_'+a.name" :key="k+'_'+a.name">{{a.name}} </option>
                      </select>   
                       <input type="hidden" v-model="formData.school_id">
        </div>
        
</template>
<template v-slot:buttons>
    <button  :disabled="loadingStatus.isLoading" class="w-full pl-[20%] md:pl-0 md:w-[30%] h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="updateStudent()" ><p class="flex text-center text-white pl-[10%]">
    <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <svg  v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
            &nbsp;&nbsp;<font class='pt-1'>Update Records</font></p></button>
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
import locations from '../../data/locations.json'



export default {
      name:"updateStudentPopup",
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
        const districts = ref([])
        const sector = ref([])
        const cell = ref([])
        const villages = ref([])
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
            location_province:"",
            location_district:"",
            location_sector:"",
            location_cell:"",
            location_village:"",
            school_id:"",
            student_id:generateKey(10),
            registered_by:"",
            page:1,
            limit:localStorage.getItem('numRows') ?? 10,
            sort:'name',
            sort_by:'ASC'

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
            // fathers_ID:{
            //     maxlength:16,
            //     counter:true,
            //     validationClass:"ring-1 ring-red-500",
            // },
            // mothers_ID:{
            //     maxlength:16,
            //     counter:true,
            //     validationClass:"ring-1 ring-red-500",
            // }
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
            // fathers_ID:{
            //     counter:"$count / $maxlength digits",
            //     slot:"",
            //     className:""
            // },
            // mothers_ID:{
            //     counter:"$count / $maxlength digits",
            //     slot:"",
            //     className:""
            // },
        });

        function display_sectors(){
          sector.value=sectors[event.target.value];
        }

        function validate (messages,rules,formData,event){
            return validations(messages,rules,formData,event)
        }

        function updateStudent(){
            if(validate(messages.value,rules.value,formData.value))
            {
                formData.value.page = 1
                formData.value.limit = localStorage.getItem('numRows') ?? 10
                formData.value.sort = 'name'
                formData.value.sort_by = 'ASC'

                return studentsStores.updateStudent(formData.value)
            }
        }

        function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
        successFeedbackStatus.value =! successFeedbackStatus.value
        }


        const loadingStatus = computed(() => {
            successFeedbackStatus.value = studentsStores.successMessageArr != "" ? false : true
            return studentsStores.loadingUI
        });

        const popUpDetails = computed(() => {
            return uiStore.popupDetails.popup_data
        })


        function showPopUp(){
            return uiStore.openPopUpFunc();
        }

        const getClassroomList = computed(() => {
            return classroomstore.classroomList.classrooms;
        });

        const errorStatus = computed(() => {
            return studentsStores.errorMessage
        });


        const successStatus = computed(() => {
            successFeedbackStatus.value =! successFeedbackStatus.value
            return studentsStores.successMessage
        });

        function display_districts(){
            let k = event.target.value
            k = parseInt(k.split('_')[0])
            console.log(locations.provinces[k].districts)
            districts.value = locations.provinces[k].districts.map((p,v)=>locations.provinces[k].districts[v])
        }

        function display_sectors(){
            let prov = parseInt(formData.value.location_province.split('_')[0])
            let dist = parseInt(formData.value.location_district.split('_')[0])
            sector.value = locations.provinces[prov].districts[dist].sectors.map((p,v)=> locations.provinces[prov].districts[dist].sectors[v])
        }

        function display_cells(){
            let prov = parseInt(formData.value.location_province.split('_')[0])
            let dist = parseInt(formData.value.location_district.split('_')[0])
            let sect = parseInt(formData.value.location_sector.split('_')[0])            
            cell.value = locations.provinces[prov].districts[dist].sectors[sect].cells.map((p,v)=> locations.provinces[prov].districts[dist].sectors[sect].cells[v])
        }

        function display_villages(){
            let prov = parseInt(formData.value.location_province.split('_')[0])
            let dist = parseInt(formData.value.location_district.split('_')[0])
            let sect = parseInt(formData.value.location_sector.split('_')[0]) 
            let cell = parseInt(formData.value.location_cell.split('_')[0])
            villages.value = locations.provinces[prov].districts[dist].sectors[sect].cells[cell].villages.map((p,v)=> locations.provinces[prov].districts[dist].sectors[sect].cells[cell].villages[v])
        }



        onMounted(() => {
            districts.value = districtsList
            if(userStore.getUserData())
            {
                setTimeout(function (){
                    classroomstore.getClassroomList(userStore.userDetails.school_id)
                    formData.value.school_id = userStore.userDetails.school_id
                    formData.value.registered_by = userStore.userDetails.account_id 
                    for(const data in formData.value)
                    {
                        formData.value[data] = uiStore.popupDetails.popup_data[data]
                    }
                },500);
            }
        });
        return {messages,formData,rules,slotData,isPopUpOpened,showPopUp,updateStudent,validate,loadingStatus,getClassroomList,districts,sector,display_sectors,closeFeedback,feedbackStatus,successFeedbackStatus,successStatus,onlyNumberKey,errorStatus,popUpDetails,cell,villages,display_districts,display_cells,display_villages,locations}
       },
    }
    </script>

    