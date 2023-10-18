<template >
      <div class="w-[100px]">&nbsp;</div>

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
       
      <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus == 'success' ? 'We sent you an email with reset password link.':'' "  type="success" :closeMethod="closeFeedback"/>



      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-[2%] md:ml-[38%] text-center shadow-lg">
        <p class=" text-lg font-bold"> Complete school registration</p>
        <p class=" pt-2 text-sm font-light">Hi <b>{{getSchoolDemoInfo != undefined ? getSchoolDemoInfo.name : ''}}</b>, Once registration is completed you'll receive 1 month free trial </p>
        <div class="pt-4 space-y-3">

          <hr class="mt-4">
          <p class=" text-md font-bold"> User information</p>
          <hr>

          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter your names' v-model="formData.name" id="formData.name" readonly />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.name.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='email' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter your email' v-model="formData.email" id="formData.email"  />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.email.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">Phone number: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.phone_number" id="formData.phone_number"  placeholder='Enter your phone number' readonly/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.phone_number.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">Password: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='password' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.password" id="formData.password"  placeholder='Enter password you wish to use'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.password.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">Confirm password: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='password' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.password_confirmation" id="formData.password_confirmation"  placeholder='Confirm your password'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.password_confirmation.slot}}</span>
          </div>
          <hr class="mt-4">
          <p class=" text-md font-bold"> School information</p>
          <hr>

          <p class="pt-2 text-sm font-bold text-left">School name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.school_name" id="formData.school_name"  placeholder='Enter school name' readonly/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_name.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">School email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.school_email" id="formData.school_email"  placeholder='Enter school email'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_email.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">School phone number: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.school_phone_number" id="formData.school_phone_number"  placeholder='Enter school phone number'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_phone_number.slot}}</span>
          </div>

         <p class="pt-2 text-sm font-semibold text-left">Select location district: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='display_sectors($event),validate(messages,rules,formData,$event)'  name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.district"  v-model="formData.district"  >
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.district.slot}}</span>
                      </div>

          <p class="pt-2 text-sm font-semibold text-left">Select location sector: <span class=" text-red-600" title="Required field">(*)</span></p>
          <select name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.sector" id="formData.sector" @change="validate(messages,rules,formData,$event)">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.sector.slot}}</span>
                      </div>
<br>
          <label class="text-xs font-light text-left cursor-pointer" for="term_and_conditions"> <input type="checkbox" class="mt-5"  v-model="formData.accepted" id="formData.accepted" @change="validate(messages,rules,formData,$event)">&nbsp;&nbsp;I have read and accepted our <router-link to="/resetPassword"><a href="#" class=" text-xs font-semibold  hover:text-[#0673c3]">Terms & Conditions </a></router-link></label><br>
          <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.accepted.slot}}</span>
                      </div>
        
          <button  class="w-full h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="completeRegistration()" :disabled="loadingStatus.isLoading"><p class="flex text-center text-white pl-[20%]">
            Complete Registration&nbsp;&nbsp;
            <svg v-if="loadingStatus.isLoading" class="animate-spin -ml-1 mr-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
            <svg v-if="loadingStatus.isLoading == false" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
            </svg>
</p>

          </button>
         
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  import { useUserStore } from '../../stores/auth'
  import districtsList from "../../data/districts.json"
  import sectors from '../../data/sectors.json'
  import Alert from '../../components/alert.vue'
  import {validations} from "../../helpers/validations"
  import { ref,computed,onMounted } from 'vue';
  import { useRouter,useRoute } from 'vue-router';


  export default {
    name:"registerSchool",
    components:{
      Alert
  },
  setup(){

    const router = useRouter();
    const route = useRoute();
    const store = useUserStore();
    const feedbackStatus = ref(false);
    const successFeedbackStatus = ref(false);
    const districts = ref([]);
    const sector = ref([]);

    const formData = ref({
      school_name: "",
      name:"",
      email: "",
      phone_number:"",
      password:"",
      password_confirmation:"",
      district:"",
      sector:"",
      school_phone_number:"",
      school_email:"",
      token:route.params.token,
      accepted:""
    });
    const rules = ref({
      school_name: {
        required: true,
        validationClass:"ring-1 ring-red-500",
      },
      name:{
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      email: {
        email:true,
        validationClass:"ring-1 ring-red-500",
      },
      phone_number: {
        required:true,
        counter:true,
        maxlength:10,
        validationClass:"ring-1 ring-red-500",
      },
      password: {
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      password_confirmation: {
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      school_name: {
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      school_phone_number: {
        required:true,
        counter:true,
        maxlength:10,
        validationClass:"ring-1 ring-red-500",
      },
      school_email: {
        email:true,
        validationClass:"ring-1 ring-red-500",
      },
      district:{
        required: true,
        validationClass:"ring-1 ring-red-500",
      },
     sector:{
        required: true,
        validationClass:"ring-1 ring-red-500",
     },
     accepted:{
        required: true,
        validationClass:"ring-2 ring-red-500",
     },
  });
  const messages = ref({
    school_name: {
        required: "School name is required",
        slot:"",
        className:""
      },
      name:{
        required:"Your names are required",
        slot:"",
        className:""
      },
      email: {
        required: "Your email is required",
        email:"Enter valid email",
        slot:"",
        className:""
      },
      phone_number: {
        required: "Your phone number is required",
        counter:"$count out of $maxlength digits",
        slot:"",
        className:""
      },
      password: {
        required:"New password is required",
        slot:"",
        className:""
      },
      password_confirmation: {
        required:"Password confirmation field is required",
        slot:"",
        className:""
      },
      school_name: {
        required:"School name field is required",
        slot:"",
        className:""
      },
      school_email: {
        email: "School email is required",
        slot:"",
        className:""
      },
      school_phone_number: {
        required: "Your phone number is required",
        counter:"$count out of $maxlength digits",
        slot:"",
        className:""
      },
      district:{
        required: "District location is required",
        slot:"",
        className:""
      },
     sector:{
        required: "Sector location is required",
        slot:"",
        className:""
        },
    accepted:{
        required: "Please accept our terms and conditions",
        slot:"",
        className:""
        },
  });

  function validate (messages,rules,formData,event){
     return validations(messages,rules,formData,event)
  }

  function display_sectors(){
          sector.value=sectors[event.target.value];
       }

  function closeFeedback() {
        feedbackStatus.value =! feedbackStatus.value
        successFeedbackStatus.value =! successFeedbackStatus.value
      }

  function completeRegistration(){
    if(validate(messages.value,rules.value,formData.value))
      {
        return store.complete_registration(formData.value);
      }
    }

    const successStatus = computed(() => {
      formData.value.school_name=""
      formData.value.name=""
      formData.value.email= "",
      formData.value.phone_number=""
      formData.value.password=""
      formData.value.password_confirmation=""
      formData.value.district=""
      formData.value.sector=""
      formData.value.school_phone_number=""
      formData.value.school_email=""
      formData.value.accepted=""
       return store.successMessage
    });

    const errorStatus = computed(() => {
       return store.errorMessage
    });

    const getSchoolDemoInfo = computed(() => {
        store.demoSchoolInfo.School_registration_requests != undefined ? (store.demoSchoolInfo.School_registration_requests == 'null' ? router.push({ path:"/auth/login"}) : "" ) : ""
        formData.value.school_name =  store.demoSchoolInfo.School_registration_requests != undefined ? store.demoSchoolInfo.School_registration_requests.school_name : ""
        formData.value.name = store.demoSchoolInfo.School_registration_requests != undefined ? store.demoSchoolInfo.School_registration_requests.name : ""
        formData.value.email = store.demoSchoolInfo.School_registration_requests != undefined ? store.demoSchoolInfo.School_registration_requests.email : ""
        formData.value.phone_number = store.demoSchoolInfo.School_registration_requests != undefined ? store.demoSchoolInfo.School_registration_requests.phone_number : ""     
        return store.demoSchoolInfo.School_registration_requests
    });

    const loadingStatus = computed(() => {
      feedbackStatus.value = store.errorMessage != "" ? false : true
       return store.loadingUI
    });


    onMounted(() => {
      store.get_registration_request_info(route.params.token)
      districts.value = districtsList
    });

    return {
      messages,formData,rules,feedbackStatus,successFeedbackStatus,closeFeedback,districts,sector,display_sectors,validate,errorStatus,successStatus,loadingStatus,completeRegistration,getSchoolDemoInfo
    }
  
    },
  }
  </script>

