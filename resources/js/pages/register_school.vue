<template >
      <div class="w-[100px]">&nbsp;</div>
      <div class=" w-[400px] bg-white p-8  rounded-3xl mt-[90px] ml-14 md:ml-[450px] text-center shadow-lg">
        <p class=" text-lg font-bold"> Send school registration request</p>
        <p class=" pt-2 text-sm font-light"> Are you ready to try our system, please fill the form below we'll reach you as soon as possible.</p>
        <div class="pt-4 space-y-3">
          <p class="pt-2 text-sm font-bold text-left">School name: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' :class="messages.school_name.className"   @keyup="validation" v-model="formData.school_name"  placeholder='Enter school name'/>
          <div class="text-end">
            <span class=" text-red-600 text-xs" >{{messages.school_name.slot}}</span>
          </div>
          

          <p class="pt-2 text-sm font-semibold text-left">Names: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='text' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validation" placeholder='Enter your names' v-model="formData.names" :class="messages.names.className" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.names.slot}}</span>
          </div>
          
         

          <p class="pt-2 text-sm font-semibold text-left">Email: <span class=" text-red-600" title="Required field">(*)</span></p>
          <input type='email' class='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' @keyup="validation" placeholder='Enter your email' v-model="formData.email" :class="messages.email.className" />
          <div class="text-end">
          <span class="  text-red-600 text-xs" >{{messages.email.slot}}</span>
          </div>


          <p class="pt-2 text-sm font-semibold text-left">Bank you work with:</p>
          <input type='text' className='w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg    placeholder:p-1 placeholder:font-light  enabled:p-2' placeholder='Enter the bank you work with' />
         <br>
         <p class="pt-2 text-sm font-semibold text-left">Select location district: <span class=" text-red-600" title="Required field">(*)</span></p>
         <select @change='display_sectors($event)'  name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg   enabled:p-2 enabled:font-light" id="exampleInputSchoolDistrict"  v-model="formData.district" :class="messages.district.className" >
                      <option value=''>Select district</option>
                      <option v-for="a in districts" :value="a.name" :key="a.name">{{a.name}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.district.slot}}</span>
                      </div>

                      <p class="pt-2 text-sm font-semibold text-left">Select location sector: <span class=" text-red-600" title="Required field">(*)</span></p>
                      <select name='school_district' class="w-[330px] h-9 ring-2 ring-[#f6f6f6] rounded-lg enabled:p-2 enabled:font-light" id="exampleInputSchoolSector" v-model="formData.sector" :class="messages.sector.className">
                      <option value=''>Select location sector:</option>
                      <option  v-for="a in sector" v-bind:value="a.sector" :key="a.sector">{{a.sector}} </option>
                      </select>
                      <div class="text-end">
                      <span class="  text-red-600 text-xs" >{{messages.sector.slot}}</span>
                      </div>
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

    formData:{
    school_name: "",
    names:"",
    email: "",
    district:"",
    sector:"",
    },  

    rules: {
      school_name: {
        required: true,
      },
      names:{
        required:true,
      },
      email: {
        email:true
      },
      district:{
        required: true,
      },
     sector:{
        required: true,
     },
     className:"ring-1 ring-red-500"
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
      },
          
  }),
    setup() {
     },
     methods:{
        display_sectors(){
        this.sector=sectors[event.target.value];
       },
       sendRequest(){
        if(this.validation())
        {
          alert('validation')
        }
       },

       validation(){
        let isValidated = []
          for(const prop in this.rules)
          {
            if(this.rules[prop]['required'])
            {
              if(this.formData[prop] == "" )
              {
                this.messages[prop]['slot'] =  this.messages[prop]['required'];
                this.messages[prop]['className'] = this.rules['className'];
              }
              else
              {
                this.messages[prop]['slot'] = ""
                this.messages[prop]['className'] = ""
              }            
              isValidated.push(this.formData[prop] != "");
            }

            if(this.rules[prop]['email'])
            {
              if(this.validateEmail(this.formData[prop]) == false)
              {
                this.messages[prop]['slot'] =   this.messages[prop]['email'] 
                this.messages[prop]['className'] = this.rules['className'];
              }
              else
              {
                this.messages[prop]['slot'] = ""
                this.messages[prop]['className'] = "";
              }
              
              isValidated.push(this.validateEmail(this.formData[prop]));
            }

            if(this.rules[prop]['minlength'] != undefined)
            {
              if(this.formData[prop].length < parseInt(this.rules[prop]['minlength']))
              {
                this.messages[prop]['slot'] =   this.messages[prop]['minlength'].replace("$minlength",this.rules[prop]['minlength']);
                this.messages[prop]['className'] = this.rules['className'];
                isValidated.push(this.validateEmail(this.formData[prop]));

              }
             
            }
            
          }
            console.log(isValidated.toString());
          return isValidated.toString().includes('false')?false:true;
       },

       validateEmail(input) {
          var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

          if (input.match(validRegex)) {

            return true;

          } else {
            return false;
          }
        }


     }
  }
  </script>

