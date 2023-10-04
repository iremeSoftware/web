<template >
      <div class="w-[100px]">&nbsp;</div>

      <Alert :feedback=feedbackStatus :message=feedbackMessage :type=feedbackType :closeMethod="closeFeedback" ></Alert>



      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[38%] text-center shadow-lg">
        <p class=" text-lg font-bold"> Send school registration request</p>
        <p class=" pt-2 text-sm font-light"> Are you ready to try our system, please fill the form below we'll reach you as soon as possible.</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">School name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2'    @keyup="validate(messages,rules,formData)" v-model="formData.school_name" id="formData.school_name"  placeholder='Enter school name'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_name.slot}}</span>
          </div>
          

          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData)" placeholder='Enter your names' v-model="formData.names" id="formData.names" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.names.slot}}</span>
          </div>
          
         

          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='email' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validate(messages,rules,formData)" placeholder='Enter your email' v-model="formData.email" id="formData.email" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.email.slot}}</span>
          </div>

         <p class="pt-2 text-sm font-semibold text-left">Select location district: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='display_sectors($event),validate(messages,rules,formData)'  name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="formData.district"  v-model="formData.district"  >
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.district.slot}}</span>
                      </div>

                      <p class="pt-2 text-sm font-semibold text-left">Select location sector: <span class=" text-red-600" title="Required field">(*)</span></p>
                      <select name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" v-model="formData.sector" id="formData.sector" @change="validate(messages,rules,formData)">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.sector.slot}}</span>
                      </div>
<br>
          <label class="text-xs font-light text-left cursor-pointer" for="term_and_conditions"> <input type="checkbox" class="mt-5"  v-model="formData.accepted" id="formData.accepted" @change="validate(messages,rules,formData)">&nbsp;&nbsp;I have read and accepted our <router-link to="/resetPassword"><a href="#" class=" text-xs font-semibold  hover:text-[#0673c3]">Terms & Conditions </a></router-link></label><br>
          <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.accepted.slot}}</span>
                      </div>
        
          <button  class="w-full h-10 text-sm rounded-lg  font-semibold bg-[#000000]" @click="sendRequest()"><p class="flex text-center text-white pl-[110px]">
            Send Request&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
</svg>
</p>

          </button>
         
        </div>
      </div>
      <div class="h-[40px]">&nbsp;</div>
    
  </template>
  <script>
  import districts from "../../data/districts.json"
  import sectors from '../../data/sectors.json'
  import Alert from '../../components/alert.vue'
  import {validations} from "../../helpers/validations"


  export default {
    name:"register_school",
    components:{
      Alert
  },
  data :() => ({
    districts:districts,
    sector:[''],
    selected_district:'',

    feedbackStatus:false,
    feedbackMessage:"",
    feedbackType:"",

    formData:{
    school_name: "",
    names:"",
    email: "",
    district:"",
    sector:"",
    accepted:""
    },  

    rules: {
      school_name: {
        required: true,
        validationClass:"ring-1 ring-red-500",
      },
      names:{
        required:true,
        validationClass:"ring-1 ring-red-500",
      },
      email: {
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
    },

    messages: {
      school_name: {
        required: "School name is required",
        slot:"",
        className:""
      },
      names:{
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
      },
          
  }),
    setup() {
     },
     methods:{
        validate: (messages,rules,formData) =>  validations(messages,rules,formData),
        display_sectors(){
          console.log(sectors[event.target.value]);
        this.sector=sectors[event.target.value];
       },
       closeFeedback() {
       this.feedbackStatus =! this.feedbackStatus
       },
       sendRequest(){
        if(this.validate(this.messages,this.rules,this.formData))
        {
          this.feedbackStatus = true
          this.feedbackMessage="New account created successfully"
          this.feedbackType="success"
        }
       },


     }
  }
  </script>

