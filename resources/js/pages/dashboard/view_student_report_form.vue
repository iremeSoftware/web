
<template >
    <div class="w-full flex" >
      <sidebarVue />
      <div class="w-full md:w-5/6">
        <Header2 />
        <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
          <!-- <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
            👋 Welcome to {{ getUsers.school_name }}
            </h1> -->
            <Alert v-if="successStatus !='' && successFeedbackStatus ==false" :message="successStatus"  type="success" :closeMethod="closeFeedback"/>

            <Alert  v-if="errorStatus !='' && errorFeedbackStatus ==false" :message="errorStatus.message" type="danger" :closeMethod="closeFeedback"/>


            <p class="flex text-16px md:text-2xl font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg> &nbsp;&nbsp;Generate Report Form - {{ getStudentRanks?.Ranks?.name }} - 
                 {{ classroomDetails!=undefined ? classroomDetails.classroom_name : '' }} 
  
            </p>
        </div>

        

        <DataTable>
          <template v-slot:table>
            
            <div class="flex truncate overflow-x-auto w-full h-14">
              <!-- <button class="ml-2 mt-1 md:w-44 h-6 pt-1 md:pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  onclick="history.back()"><p class="flex pl-2  space-x-2 text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
              </svg>              
              <font class="pt-1">Back </font></p>
            </button> -->

            <p class="text-sm md:text-md font-semibold text-left mt-2 pr-2">Choose format:</p>
            <select @change="setReportFormat()"  name='select_user_role' v-model="formData.report_type" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
              <option v-for="report in reportFormList" :value="report.type">
              {{ report.value }}
              </option>
            
            </select>

            <p class="ml-10 text-sm md:text-md font-semibold text-left mt-4 pr-2">Choose Font Type:</p>
            <select @change="setReportFont()" v-model="formData.font_type" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light ">
              <option v-for="font in fontList" :value="font.font_value">
              {{ font.font_name }}
              </option>
            </select>


          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Select Term:</p>
          <select  name='select_user_role' @change="setCurrentTerm()"  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light md:ml-4 " v-model="formData.term">
            <option v-for="term in termList" :value="term.term_no">
              {{ term.term_name }}
            </option>
          </select>

          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Publishing date:</p>
          <input type="date" class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light md:ml-4 " @change="changeDate">

            
          </div>

          <div class="flex overflow-x-auto h-14 mb-6">
              <button class="ml-2 mt-1 md:w-44 h-6 pt-1 md:pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="goToNext(-1)"><p class="flex pl-1  space-x-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
              </svg>
              <font class="pt-1">PREVIOUS STUDENT </font></p>
            </button>

           <p class='ml-8 mt-4'>{{ steps }} of {{getStudentRanks?.no_of_students }}</p>

            <button class="ml-14 mt-1 md:w-44 h-6 pt-1 pl-4 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="goToNext(1)"><p class="flex pl-2  space-x-2 text-white">             
              <font class="pt-1">NEXT STUDENT</font>
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
              </svg>
             </p>
            </button>
          </div>

          <div class="fixed  mt-[15%] ml-[75%] w-20 space-y-6">
            <button class="ml-2 mt-1 md:w-10 h-6 pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="paddingSteps(0.5)"><p class="flex pl-2  space-x-2 text-white">             
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
             </p>
            </button>

            <button class="ml-2 mt-1 md:w-10 h-6 pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="paddingSteps(-0.5)"><p class="flex pl-2  space-x-2 text-white">             
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
              </svg>
             </p>
            </button>

            <button class="ml-2 mt-1 md:w-10 h-6 pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-white shadow-lg hover:scale-x-105"  @click="print_pdf"><p class="flex pl-2  space-x-2 text-white">             
                <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path  d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/></svg>
             </p>
            </button>
          </div>
          <div class="overflow-x-auto"  id="dataTable" >
             <table class="w-full text-[10px] text-left text-gray-500 dark:text-gray-400" :style="formData.font_type">
                <tbody class="border">
                    <tr class="bg-white  dark:bg-gray-900 dark:border-gray-700">
                    <td class="px-3 py-4">
                      <img :src="`/school_logo/${currentUser.logo}`" width=100 height=100>
                    </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                    <td class="px-4 md:px-6 py-2" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                     School name: <b>{{ currentUser.school_name }}</b><br>
                     Motto: <b>{{ currentUser.school_motto }}</b><br>
                     Location: <b>{{ currentUser.school_sector }}, {{ currentUser.school_district }}</b><br>
                     Phone number: <b>{{ currentUser.phone_number }}</b><br>
                     Contact Email: <b>{{ currentUser.school_email }}</b><br>
                     Trimestre: <b>{{ formData.term ==1?'First Term':(formData.term ==2?'Second Term':'Third Term') }}</b><br>
                    </td>
                     </tr>
                     <tr class="bg-white dark:bg-gray-900 dark:border-gray-700">
                       <td colspan="2" class="px-4 md:px-6 py-4 text-center" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                        <h3 class="text-2xl font-semibold" v-if="formData.report_type == 'advanced_report'">STUDENT REPORT FORM</h3>
                        <h3 class="text-2xl font-semibold" v-else-if="formData.report_type == 'mid_term_report'">CONTINUOUS ASSESSMENT TEST REPORT FORM</h3>

                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                      <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`" >
                       NAMES : <b>{{ getStudentRanks?.Ranks?.name }}</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       ACADEMIC YEAR : <b>{{ getStudentRanks?.academic_year }}</b>
                       </td>
                     </tr>
                     <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                      <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       CLASS : <b>{{ getStudentRanks?.classroom }}</b>
                       </td>
                       <td class="px-6 py-4 border" :class="`px-[${padding_steps.px}px] py-[${padding_steps.py}px]`">
                       STUDENT ID : <b>{{ getStudentRanks?.Ranks?.my_id }}</b>
                       </td>
                     </tr>
                </tbody>
                </table>
                <template v-if="formData.report_type == 'advanced_report'">
                  <FirstTermSingleReport v-if="formData.term ==1" :getStudentRanks="getStudentRanks" :selected_type="formData.font_type" is_for_all_students="false" 
                  :student_total_number="getStudentRanks?.no_of_students" :padding_steps="padding_steps" />

                  <SecondTermSingleReport v-if="formData.term ==2" :getStudentRanks="getStudentRanks" :selected_type="formData.font_type" 
                  is_for_all_students="false"
                  :student_total_number="getStudentRanks?.no_of_students"  
                  :padding_steps="padding_steps"/>

                  <ThirdTermSingleReport v-if="formData.term ==3" :getStudentRanks="getStudentRanks" 
                  :selected_type="formData.font_type" is_for_all_students="false" 
                  :student_total_number="getStudentRanks?.no_of_students" 
                  :padding_steps="padding_steps"/>

                </template>
                <template v-else-if="formData.report_type == 'mid_term_report'">
                  <MidTermSingleReport :getStudentRanks="getStudentRanks" :selected_type="formData.font_type" :padding_steps="padding_steps" is_for_all_students="false" 
                  :student_total_number="getStudentRanks?.no_of_students" :term="formData.term" />
                </template>

                

                <table class="mt-2 w-full  text-[10px] text-left text-gray-500 dark:text-gray-400" :style="formData.font_type" >
                <tbody class=" mt-2">
                  <tr class="bg-white dark:bg-gray-900 dark:border-gray-700 ">
                        <td>
                          <b>SCAN FOR VERIFICATION</b>
                        </td>
                        <td class="px-6 py-4">
                          <b>TEACHER'S REMARKS & SIGNATURE</b>
                        </td>
                        <td class="px-6 py-4">
                          <b>PARENT'S REMARKS & SIGNATURE</b>
                        </td>
                        <td class="px-6 py-6">
                          <b>AUTHORISED SIGNATURE AND STAMP</b>
                          <br>
                          Done on <b>{{ selectedDate }}</b>
                        </td>
                  </tr>
                  <tr class="bg-white dark:bg-gray-900 dark:border-gray-700 ">
                        <td>
                          <div class="h-20 w-20 mb-4">
                            <vue-qrcode
                            :value="dataUrl"
                            @change="onDataUrlChange"
                          />
                          </div>
                        </td>
                        <td>
                          <p class="flex-wrap w-20"></p>
                         
                          <hr class="mt-5">
                        </td>
                        <td>
                          <hr class="ml-6 mt-5">
                        </td>
                        <td>
                          <hr class="ml-6 mt-5">
                        </td>
                  </tr>
                </tbody>
            </table>
          </div>
          <div class="flex overflow-x-auto h-14 mb-6">
              <button class="ml-2 mt-1 md:w-44 h-6 pt-1 md:pt-1 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="goToNext(-1)"><p class="flex pl-1  space-x-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
              </svg>
              <font class="pt-1">PREVIOUS STUDENT </font></p>
            </button>

           <p class='ml-8 mt-4'>{{ steps }} of {{getStudentRanks?.no_of_students }}</p>

            <button class="ml-14 mt-1 md:w-44 h-6 pt-1 pl-4 md:h-10 text-xs md:text-sm rounded-lg ring-2 ring-black bg-black shadow-lg hover:scale-x-105"  @click="goToNext(1)"><p class="flex pl-2  space-x-2 text-white">             
              <font class="pt-1">NEXT STUDENT</font>
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
              </svg>
             </p>
            </button>

          </div>

          
</template>
<template v-slot:printBtns>
    <div class="flex text-xs md:text-sm space-x-4" @mousemove="hideCols(true)" >
            <!-- <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md ring-2 ring-black shadow-lg hover:scale-x-105" @click="print_pdf"><p class="flex pl-2  space-x-2">
              <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path  d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/></svg>
              <font class="pt-1">Print PDF</font></p>
            </button> -->
    </div>

    
  </template>
  <template v-slot:entries>
    <!-- Show {{ firstItem }} to {{ lastItem }} of {{ studentsMarks?.no_of_students }} students -->
  </template>
  
 
  <template v-slot:migrateSection>

  </template>

  </DataTable>
  
          <div v-if="isLoading" class="absolute top-[60%] left-[50%]">
                      <svg class="animate-spin text-black h-14 w-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
            </div> 
         </div>
    </div>
    </template>
<script>
  import Alert from '../../components/alert.vue'
  import Header2 from '../../components/header2.vue'
  import sidebarVue from '../../components/sidebar.vue'
  import { useUserStore } from '../../stores/auth'
  import { onMounted,ref,computed,watch } from 'vue'
  import { useRoute,useRouter } from 'vue-router'
  import { classroomStore } from '../../stores/classroom'
  import confirmationPrompt from '../../components/popup_forms/confirmation_prompt.vue'
  import DataTable from '../../components/DataTable.vue'
  import StudentPointsCard from '../../components/StudentPointsCard.vue'
  import {setPageTitle} from '../../helpers/set_page_title'
  import {studentsMarksStore} from '../../stores/student_marks'
  import VueQrcode from 'vue-qrcode'
  import FirstTermSingleReport from '../../components/report_form/advanced_reports/first_term_single_report.vue'
  import SecondTermSingleReport from '../../components/report_form/advanced_reports/second_term_single_report.vue'
  import ThirdTermSingleReport from '../../components/report_form/advanced_reports/third_term_single_report.vue'
  import MidTermSingleReport from '../../components/report_form/midterm_reports/mid_term_single_report.vue'
  import { studentsStore } from '../../stores/students'





  export default {
      name:"viewStudentReportForm",
      components:{
        Alert,
        Header2,
        sidebarVue,
        confirmationPrompt,
        DataTable,
        StudentPointsCard,
        VueQrcode,
        FirstTermSingleReport,
        SecondTermSingleReport,
        ThirdTermSingleReport,
        MidTermSingleReport
     },
    setup() {
      const store = useUserStore()
      const studentsStores = studentsStore()
      const currentUser = ref([])
      const route = useRoute()
      const router = useRouter()
      const classroomStores = classroomStore()
      const studentsMarksStores = studentsMarksStore()
      let studentsList = ref([]) 
      let classroomDetails = ref([]) 
      let studentsMarks = ref([])
      let termList = ref([
        {
          'term_no':1,
          'term_name':'First Term'
        },
        {
          'term_no':2,
          'term_name':'Second Term'
        },
        {
          'term_no':3,
          'term_name':'Third Term'
        },
      ])


      let sortList = ref([
        {
          'sort':'name-ASC',
          'sort_name':'Name (A-Z)'
        },
        {
          'sort':'name-DESC',
          'sort_name':'Name (Z-A)'
        }
      ])

      let fontList = ref([
        {
          'font_name':'Rubik',
          'font_value':"font-family: 'Rubik';"
        },
        {
          'font_name':'Times New Roman',
          'font_value':"font-family:Georgia, 'Times New Roman', Times, serif;"
        },

        {
          'font_name':'Lucida Sans Regular',
          'font_value':"font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"
        },
        {
          'font_name':'Verdana',
          'font_value':"font-family: 'Vardena';"
        },
      ])


      let reportFormList = ref([
        {
          'type':'advanced_report',
          'value':'End of Term Report Format'
        },
        {
          'type':'mid_term_report',
          'value':'Mid-Term Report Format'
        },
        {
          'type':'nursery_report',
          'value':'Colored Report Format'
        },
      ])

      const steps = ref(1)
      const padding_steps = ref({
        'px':5,
        'py':16,
        'font_size':12
      })

      const inputQuizError = ref([])
      const inputExamError = ref([])
      const hasValidationError = ref([])
      let errorStatus =ref("")
      const dataUrl = ref (window.location.href)
      var options = {
         weekday: 'long',
         year: 'numeric', 
         month: 'long',
         day: 'numeric' 
        }
      const selectedDate = ref(new Date().toLocaleDateString("en-US", options))

      const formData = ref({
              student_name:"",
              student_id:ref(route.params.student_id),
              school_id:"",
              class_id:ref(route.params.class_id),
              page:1,
              account_id:"",
              course_id:"all",
              limit:localStorage.getItem('numRows') ?? 10,
              sort_by:'name',
              sort:'ASC',
              term:ref(route.params.term),
              term_quiz:0,
              term_exam:0,
              sort_records:localStorage.getItem('currentSort') ?? sortList.value[0].sort,
              font_type:fontList.value[0].font_value,
              report_type:localStorage.getItem('report_type') ?? reportFormList.value[0].type 
            });


      let quiz_marks = ref([])
      let exam_marks = ref([])
      const successFeedbackStatus = ref(false)
      const errorFeedbackStatus = ref(false)
      const getUsers = computed(() => {
        currentUser.value = store.userDetails
       return currentUser.value;
      });
  
  
      classroomDetails = computed (() => {
        return classroomStores.classroomDetails
      })
  
      studentsMarks = computed (() => {
        return studentsMarksStores.studentsSorts
      })
  
      const isLoading = computed (() => {
        return studentsMarksStores.loadingUI.isLoading
      })
  
      watch(route,() => {
        formData.value.class_id = route.params.class_id
        dataUrl.value = window.location.href
        getStudentsRanks()
       });
  
       function getClassTeacherByClass(){
         return classroomStores.getClassTeacherByClass(currentUser.value.school_id,route.params.class_id)
       }
  
  
      function checkAuth(){
            console.log(currentUser.value)
            if(store.userDetails != undefined){
              if(!store.userDetails.authentications?.includes('generate_report'))
              {
                router.push('/dashboard/home')
              }
            }
        }

        function onDataUrlChange(url) {
            dataUrl.value = window.location.href
        }

        errorStatus = computed(() => {
            errorFeedbackStatus.value = false
            return studentsMarksStores.errorMessage
        });

        function closeFeedback() {
        successFeedbackStatus.value =! successFeedbackStatus.value
        errorFeedbackStatus.value =! errorFeedbackStatus.value
        }

        const successStatus = computed(() => {
            successFeedbackStatus.value = false
            return studentsMarksStores.successMessage
        });


        function setCurrentTerm(){
          formData.value.term = event.target.value
          formData.value.student_id = route.params.student_id
          formData.value.sort_by='name'
          formData.value.sort='ASC'
          localStorage.setItem('selectedTerm',formData.value.term)
          router.push(`/dashboard/report_form/${formData.value.class_id}/${formData.value.student_id}/${formData.value.term}`);
          getStudentsRanks()
        }

      function print_pdf() {
          var tableData = document.getElementById('dataTable').innerHTML;
          var tag = document.getElementsByTagName('head')[0].innerHTML;
          var cssHead = 
          tag;
                  var data = cssHead + tableData;
                  let myWindow = window.open('', '', 'width=1000px,height=1000px');
                  myWindow.innerWidth = screen.width;
                  myWindow.innerHeight = screen.height;
                  myWindow.screenX = 300;
                  myWindow.screenY = 100;
                  myWindow.document.write(data);
                  myWindow.focus();
                  setTimeout(() => {
                      myWindow.print();
                  }, 500);
              }
        
        const getStudentRanks = computed(() => {
            steps.value=studentsMarksStores?.studentsMarks?.Ranks?.my_id
            return studentsMarksStores.studentsMarks
        });


        function getStudentsRanks(){
            formData.value.student_id = route.params.student_id
            
            return studentsMarksStores.getStudentMarks(formData.value)
        }



        function changeDate(){
          let selected_Date = event.target.value
          selectedDate.value = new Date(selected_Date).toLocaleDateString("en-US", options)
        }

        
        studentsList = computed (() => {
          return studentsStores.studentsList
       })

       function goToNext(step)
       {
           if(steps.value + step >0 && steps.value + step <= studentsStores?.studentsList?.Students?.length)
           {
             if(steps.value>=1)
              {
                steps.value +=step
                let student_id = studentsStores?.studentsList?.Students?.[steps.value-1].student_id
                formData.value.sort_by='name'
                formData.value.sort='ASC'
                router.push(`/dashboard/report_form/${formData.value.class_id}/${student_id}/${formData.value.term}`);
                getStudentsRanks()
              }
           }
       }

       function paddingSteps(p_steps){
        if(padding_steps.value.px + p_steps >= 1 && padding_steps.value.py + p_steps >= 1)
        {
           if(padding_steps.value.px >=1 && padding_steps.value.py >=1)
           {
              padding_steps.value.px +=p_steps
              padding_steps.value.py +=p_steps
              padding_steps.value.font_size +=p_steps
           }
        }
       }


        function getStudentList(){
          formData.value.school_id = currentUser.value.school_id
          formData.value.class_id = route.params.class_id
          formData.value.student_id = 'null'
          formData.value.page = 1
          formData.value.limit = 'none'
          formData.value.sort_by='ASC'
          formData.value.sort='name'
          return studentsStores.getStudentList(formData.value)
        }

        function setReportFormat(){
          formData.value.report_type = event.target.value
          localStorage.setItem('report_type',formData.value.report_type)
          let url = window.location.href
          let url_Path = url.split('?')
          var searchParams = new URLSearchParams(window.location.search)
          searchParams.set('report_type',formData.value.report_type)
          url = window.location.pathname+'?'+searchParams
          window.location.href = url
        }

        
      onMounted(() => {
        setPageTitle(`Generate report form - ${studentsMarksStores?.studentsMarks?.Ranks?.name}`)
        if(store.getUserData())
        {
          setTimeout(function (){
            currentUser.value = store.userDetails
            formData.value.account_id = store.userDetails.account_id  
            checkAuth()
            getClassTeacherByClass()
            getStudentsRanks()
            getStudentList()
          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,formData,isLoading,studentsMarks,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,termList,setCurrentTerm,quiz_marks,exam_marks,sortList,inputQuizError,inputExamError,hasValidationError,print_pdf,getStudentRanks,onDataUrlChange,dataUrl,changeDate,selectedDate,steps,goToNext,fontList,padding_steps,paddingSteps,reportFormList,setReportFormat}
    }
  }
  </script>
  