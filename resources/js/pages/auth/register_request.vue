<template >
      <div class="w-[100px]">&nbsp;</div>

      <Alert  v-if="errorStatus !='' && feedbackStatus == false" :message="errorStatus" type="danger" :closeMethod="closeFeedback"/>
      <Alert v-if="successStatus !='' && successFeedbackStatus == false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>



      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px]  ml-[2%] md:ml-[38%] text-center shadow-lg">
        <p class=" text-lg font-bold"> Send school registration request</p>
        <p class=" pt-2 text-sm font-light"> Are you ready to try our system, please fill the form below we'll reach you as soon as possible.</p>
        <div class="pt-4 space-y-3">
     
          

          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter your names' v-model="formData.name" id="formData.name" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.name.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='email' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData,$event)" placeholder='Enter your email' v-model="formData.email" id="formData.email" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.email.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">School name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.school_name" id="formData.school_name"  placeholder='Enter school name'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_name.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-bold text-left">Phone number: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData,$event)" v-model="formData.phone_number" id="formData.phone_number"  placeholder='Enter your phone number'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.phone_number.slot}}</span>
          </div>

          <p class="pt-2 text-sm font-semibold text-left">Select school size: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='validate(messages,rules,formData,$event)'  name='school_scale' class="w-[330px] h-9 bg-transparent ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.school_scale"  v-model="formData.school_scale"  >
           <option value="">Select the size of the school:</option>
           <option value="0-200 Students">0-200 Students </option>
           <option value="200-600 Students">200-600 Students </option><option value="More than 600 Students">More than 600 Students </option>
          </select>
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.school_scale.slot}}</span>
          </div>

          
         <!-- <p class="pt-2 text-sm font-semibold text-left">Select location district: <span class=" text-red-600" title="Required field">(*)</span></p>
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
                      </div> -->
<br>
          <label class="text-xs font-light text-left cursor-pointer" for="term_and_conditions"> <input type="checkbox" class="mt-5"  v-model="formData.accepted" id="formData.accepted" @change="validate(messages,rules,formData,$event)">&nbsp;&nbsp;I have read and accepted our <router-link to="/resetPassword"><a href="#" class=" text-xs font-semibold  hover:text-[#0673c3]">Terms & Conditions </a></router-link></label><br>
          <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.accepted.slot}}</span>
                      </div>
        
          <button  class="w-full h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="sendRequest()"><p class="flex text-center text-white pl-[110px]">
            Send Request&nbsp;&nbsp;
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
  import { useRouter } from 'vue-router';


  export default {
    name:"registrationRequest",
    components:{
      Alert
  },
  setup(){

    const router = useRouter();
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
      // district:"",
      // sector:"",
      school_scale:"",
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
      school_scale:{
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
    //   district:{
    //     required: true,
    //     validationClass:"ring-1 ring-red-500",
    //   },
    //  sector:{
    //     required: true,
    //     validationClass:"ring-1 ring-red-500",
    //  },
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
        counter:"$count of $maxlength digits",
        slot:"",
        className:""
      },
      school_scale: {
        required: "Please select school size",
        slot:"",
        className:""
      },
    //   district:{
    //     required: "District location is required",
    //     slot:"",
    //     className:""
    //   },
    //  sector:{
    //     required: "Sector location is required",
    //     slot:"",
    //     className:""
    //     },
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

  function sendRequest(){
    if(validate(messages.value,rules.value,formData.value))
      {
        return store.registration_request(formData.value);
      }
    }

    function setPageTitle(newTitle){
      if (document.title != newTitle) {
          document.title = ""
          document.title = import.meta.env.VITE_APP_NAME +' - '+ newTitle
      }
    }

    const errorStatus = computed(() => {
       return store.errorMessage
    });

    const successStatus = computed(() => {

      formData.value.school_name= "";
      formData.value.name= "";
      formData.value.email= "";
      formData.value.phone_number= "";
      formData.value.school_scale = "";
      formData.value.accepted = "";
      successFeedbackStatus.value =  store.successMessage != "" ? false : true
      return store.successMessage
    });

    const loadingStatus = computed(() => {
      feedbackStatus.value = store.errorMessage != "" ? false : true
       return store.loadingUI
    });

    onMounted(() => {
      districts.value = districtsList
      setPageTitle("Registration Request")
    });

    return {
      messages,formData,rules,feedbackStatus,successFeedbackStatus,closeFeedback,districts,sector,display_sectors,sendRequest,validate,errorStatus,successStatus,loadingStatus
    }
  
  },

   
  }
  </script>

