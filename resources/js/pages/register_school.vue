<template >
      <div class="w-[100px]">&nbsp;</div>
      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> Send school registration request</p>
        <p class=" pt-2 text-sm font-light"> Are you ready to try our system, please fill the form below we'll reach you as soon as possible.</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">School name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' v-model="formData[0].school_name.value" :class="formData[0].school_name.value =='' ? formData[0].school_name.required.className :''" placeholder='Enter school name'/>
          <span class="w-full pl-40 text-red-600 text-xs" >{{formData[0].school_name.value =="" ? formData[0].school_name.required.value : ""}}</span>
          

          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your names' v-model="formData[1].names.value" :class="formData[1].names.value =='' ? formData[1].names.required.className :''" />
          <span class="w-full pl-40 text-red-600 text-xs" >{{formData[1].names.value =="" ? formData[1].names.required.value : ""}}</span>
          
         

          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='email' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter your email' v-model="formData[2].email.value" :class="formData[2].email.value =='' ? formData[2].email.required.className :''"/>
          <span class="w-full pl-40 text-red-600 text-xs" >{{formData[2].email.value =="" ? formData[2].email.required.value : ""}}</span>


          <p class="pt-2 text-sm font-semibold text-left">Bank you work with:</p>
          <input type='text' className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter the bank you work with'/>
         <br>
         <p class="pt-2 text-sm font-semibold text-left">Select location district: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='display_sectors($event)'  name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="exampleInputSchoolDistrict" v-model="formData[3].district.value" :class="formData[3].district.value =='' ? formData[3].district.required.className :''">
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>
                      <span class="w-full pl-40 text-red-600 text-xs" >{{formData[3].district.value =="" ? formData[3].district.required.value : ""}}</span>

                      <p class="pt-2 text-sm font-semibold text-left">Select location sector: <span class=" text-red-600" title="Required field">(*)</span></p>
                      <select name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" id="exampleInputSchoolSector" v-model="formData[4].sector.value" :class="formData[4].sector.value =='' ? formData[4].sector.required.className :''">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>
                      <span class="w-full pl-40 text-red-600 text-xs" >{{formData[4].sector.value =="" ? formData[4].sector.required.value : ""}}</span>
<br>
          <label class="text-xs font-light text-left cursor-pointer" for="term_and_conditions"> <input type="checkbox" class="mt-5" id='term_and_conditions'>&nbsp;&nbsp;I have read and accepted our <router-link to="/resetPassword"><a href="#" class=" text-xs font-semibold  hover:text-[#0673c3]">Terms & Conditions </a></router-link></label><br>
        
          <button  class="w-full h-10 text-sm rounded-lg  font-semibold bg-[#0673c3]" @click="sendRequest()"><p class="flex text-center text-white pl-[110px]">
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
  import districts from "../data/districts.json"
  import sectors from '../data/sectors.json'

  export default {
    name:"register_school",
    components:{
  },
  data :() => ({
    districts:districts,
    sector:[''],
    school_district:"",
    school_sector:"",
    selected_district:'',
    formData:[
      {
      school_name:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"School name is required"
      },
      value:""
    }},
    {
      names:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Your names are required"
      },
      value:""
    }
    },
    {
      email:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Your email address is required"
      },
      value:""
    }
    },
    {
      district:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"District location is required"
      },
      value:""
    }
    },
    {
      sector:{
      required:{
        isRequired:true,
        className:"ring-1 ring-red-500",
        value:"Sector location is required"
      },
      value:""
    }
    }
    
  ],
  isValidated:false

  }),
    setup() {
  
     },
     methods:{
        display_sectors(){
        this.sector=sectors[event.target.value];
       },
       sendRequest(){
        if(this.validated())
        {
          alert('Validated')
        }
       },

       validated(){
          
          for(const prop in this.formData)
          {
            for (const getData in this.formData[prop])
            {
              this.isValidated = this.formData[prop][getData].required.isRequired ? (this.formData[prop][getData].value == ""? false :true):true;

            }
          }
          return this.isValidated;
       }
     }
  }
  </script>

