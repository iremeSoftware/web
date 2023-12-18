
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
                </svg> &nbsp;&nbsp;Generate Students Report Form
                 ({{ classroomDetails!=undefined ? classroomDetails.classroom_name : '' }} )
  
            </p>
        </div>

        

        <DataTable>
          <template v-slot:table>
            <div class="flex overflow-x-auto h-14">
            <p class="text-sm md:text-md font-semibold text-left mt-2 pr-2">Show:</p>
            <select @change="setNumberOfRecords()"  name='select_user_role' v-model="formData.limit" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
            </select>


          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Sort Records:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light mt-1 md:ml-4 "  v-model="formData.sort_records" @change="sortRecords()">
                    <option v-for="sort in sortList" :value="sort.sort">{{ sort.sort_name }}</option>
          </select>
          

        
          </div>

          <div class="flex overflow-x-auto h-14 mt-10">
            <button class="w-auto h-8 text-sm rounded-lg text-white bg-[#000000] pr-2"><router-link :to="`/dashboard/report_form/${formData.class_id}/all/1`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Generate All 1st Term</p></router-link>
            </button>
            <button class="ml-5 w-auto h-8 text-sm rounded-lg text-white bg-[#000000] pr-2"><router-link :to="`/dashboard/report_form/${formData.class_id}/all/2`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Generate All 2nd Term</p></router-link>
            </button>
            <button class="ml-5 w-auto h-8 text-sm rounded-lg text-white bg-[#000000] pr-2"><router-link :to="`/dashboard/report_form/${formData.class_id}/all/3`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Generate All 3rd Term</p></router-link>
            </button>
          </div>


            
<!-- 
          <input type="hidden" v-set="firstItem = 0">
          <input type="hidden" v-set="lastItem = 0"> -->
          

          

         <template v-if="studentsMarks.Sorts?.length">
           <div class="md:flex md:flex-wrap mt-4">
            <div class="w-full overflow-x-auto shadow-md sm:rounded-lg" id="dataTable" >
        <table class="w-full text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class=" text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    #
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Student Names
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    First Term
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Second Term
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Third Term
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Annual Rank
                </th>
            </tr>
        </thead>
        <tbody v-if="studentsMarks.Sorts?.length">
          <tr v-for="student,i in studentsMarks.Sorts">
            <td class="px-4 md:px-6 py-4 border">
                     {{ i+studentsMarks.offset+1}}
            </td>
            <td class="px-4 md:px-6 py-4 border">
                     {{ student.name }}
            </td>
            <td class="px-4 md:px-6 py-4 border">
                    Rank: {{ student.rank_term1 }} / {{ studentsMarks.no_of_students }}<br>
                    <button class="w-32 h-8 text-sm rounded-lg text-white bg-[#000000]"><router-link :to="`/dashboard/report_form/${formData.class_id}/${student.student_id}/1`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>

                        Generate</p></router-link></button>
            </td>
            <td class="px-4 md:px-6 py-4 border">
                    Rank: {{ student.rank_term2 }} / {{ studentsMarks.no_of_students }}
                    <br>
                    <button class="w-32 h-8 text-sm rounded-lg text-white bg-[#000000]"><router-link :to="`/dashboard/report_form/${formData.class_id}/${student.student_id}/2`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>

                        Generate</p></router-link></button>
            </td>
            <td class="px-4 md:px-6 py-4 border">
                    Rank: {{ student.rank_term3 }} / {{ studentsMarks.no_of_students }}
                    <br>
                    <button class="w-32 h-8 text-sm rounded-lg text-white bg-[#000000]"><router-link :to="`/dashboard/report_form/${formData.class_id}/${student.student_id}/3`" ><p class="flex pl-4 pt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>

                        Generate</p></router-link></button>
            </td>
            <td class="px-4 md:px-6 py-4 border">
                    Rank: {{ student.rank_annual }} / {{ studentsMarks.no_of_students }}
            </td>
          </tr>

        </tbody>

        </table>
        </div>
      </div>
        
      </template>
      <template v-else >
        <div class="w-full h-10 text-lg text-center rounded-md background-transparent ring-2 ring-[#000000] mt-10 pl-4 pt-2 "><p>There is no student imported</p></div>
      </template>

</template>
<template v-slot:printBtns>
    <div class="flex text-xs md:text-sm space-x-4" @mousemove="hideCols(true)" >
            <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md ring-2 ring-black shadow-lg hover:scale-x-105" @click="print_pdf"><p class="flex pl-2  space-x-2">
              <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path  d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/></svg>
              <font class="pt-1">Print PDF</font></p>
            </button>
  
            <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md  bg-transparent ring-2 ring-black shadow-lg hover:scale-x-105"  @click="print_ms('ms-excel')"><p class="flex pl-2  space-x-2">
              <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3-18 33.1-22.2 42.4-28.6 57.7-13.9-29.1-6.9-17.3-28.6-57.7-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3 21.7-40 23-45 28.6-57.7 14.9 30.2 5.9 15.9 28.6 57.7 2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78 4.7-8-1.1-18-10.3-18z"/></svg><font class="pt-1">Print Excel File</font></p>
            </button>
    </div>
  </template>
  <template v-slot:entries>
    <!-- Show {{ firstItem }} to {{ lastItem }} of {{ studentsMarks?.no_of_students }} students -->
  </template>
  
  <template v-slot:pagination>
    
    <div v-if="studentsMarks?.no_of_students" class="flex pt-6 text-end">
            <input v-set="noOfPages = Math.ceil(studentsMarks?.no_of_students / formData.limit)" type="hidden">
            <p class=" font-semibold mt-2 pr-2"> </p>
            <button type="button" class="w-20 h-[30px] md:h-[42px] mt-[3px]   bg-transparent ring-1 ring-black  rounded-tl-lg rounded-bl-lg" :disabled="noOfPages == 1" :class="noOfPages == 1 ?'text-[#737373] bg-gray-200 cursor-not-allowed ':''" @click="selectPage(currentPage-1,noOfPages)">
              Previous
            </button>
            <button v-for="page in noOfPages" type="button" :class="currentPage == page ? 'bg-[#000000] text-white':''" class="w-12 h-[30px] md:h-[42px] mt-[3px]  ring-1 ring-black" @click="selectPage(page,noOfPages)"  >
               {{ page }}
            </button>
            <button type="button" class="w-20 h-[30px] md:h-[42px] mt-[3px]  bg-transparent ring-1 ring-black  rounded-tr-lg rounded-br-lg" :disabled="noOfPages == 1" :class="noOfPages == 1 ?'text-[#737373] bg-gray-200 cursor-not-allowed ':''" @click="selectPage(currentPage+1,noOfPages)">Next
            </button>
          </div>
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
  import { studentsStore } from '../../stores/students'
  import { uiChangesStore } from '../../stores/ui_changes'
  import confirmationPrompt from '../../components/popup_forms/confirmation_prompt.vue'
  import DataTable from '../../components/DataTable.vue'
  import StudentPointsCard from '../../components/StudentPointsCard.vue'
  import {setPageTitle} from '../../helpers/set_page_title'
  import {studentsMarksStore} from '../../stores/student_marks'

  export default {
      name:"generateReportForm",
      components:{
        Alert,
        Header2,
        sidebarVue,
        confirmationPrompt,
        DataTable,
        StudentPointsCard
     },
    setup() {
      const store = useUserStore()
      const uiStore = uiChangesStore();
      const currentUser = ref([])
      const route = useRoute()
      const router = useRouter()
      const classroomStores = classroomStore()
      const studentsStores = studentsStore()
      const studentsMarksStores = studentsMarksStore()
      const currentPage = ref(1)
      const isSorted = ref(false)
      let studentsList = ref([]) 
      let classroomDetails = ref([]) 
      let studentsMarks = ref([])
      let maximumPoints = ref({})
      let popupDetails = ref({})
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

      const inputQuizError = ref([])
      const inputExamError = ref([])
      const hasValidationError = ref([])
      let errorStatus =ref("")

      const formData = ref({
              student_name:"",
              student_id:"",
              school_id:"",
              class_id:ref(route.params.class_id),
              page:1,
              account_id:"",
              course_id:uiStore.popupDetails.course_id ?? localStorage.getItem('course_id'),
              limit:localStorage.getItem('numRows') ?? 10,
              sort_by:'name',
              sort:'ASC',
              term:localStorage.getItem('selectedTerm') ?? termList.value[0].term_no,
              term_quiz:0,
              term_exam:0,
              sort_records:localStorage.getItem('currentSort') ?? sortList.value[0].sort,
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
        getStudentsRanks()
       });
  
       function getClassTeacherByClass(){
         return classroomStores.getClassTeacherByClass(currentUser.value.school_id,route.params.class_id)
       }

  
      const popup_type = computed(() => uiStore.popup_type);
  
      function showPopUp(popup_type,to='',popup_title='',popup_message='',popup_data = {}){
        let popup_records = {
          'popup_title':popup_title,
          'popup_message':popup_message,
          'popup_data':popup_data,
        }
        return uiStore.openPopUpFunc(popup_type,to,popup_records);    
      }
  
   
      popupDetails = computed(() => {
        return uiStore.popupDetails
      })
  
      function deleteAction(){
        formData.value.student_id = uiStore.popupDetails.popup_data.student_id
        uiStore.openPopUpFunc() // Close popup
        return studentsStores.deleteStudent(formData.value)
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

          
       function setNumberOfRecords(){
          localStorage.setItem('numRows',formData.value.limit)
          getStudentsRanks()
       }

       function selectPage(num,noOfPages){
          if(num <= noOfPages && num>0) 
          {
            formData.value.page = num
            currentPage.value = num
            getStudentsRanks()
          }
       }

        maximumPoints = computed(() => 
        {
          formData.value.maximumPoints = studentsMarksStores?.maximumPoints.Out_of_marks
          return studentsMarksStores.maximumPoints
        
        })


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

        function searchStudents(){
          if(formData.value.student_name.length >2)
          {
              return studentsMarksStores.searchStudentMarks(formData.value)
          }
        }

        function clearSearch(){
           if(event.which == 8)
           {
             return getStudentsRanks()
           }
        }

        function setCurrentTerm(){
          formData.value.term = event.target.value
          localStorage.setItem('selectedTerm',formData.value.term)
          getStudentsRanks()
        }

        function sortRecords(){
          let currentSort = event.target.value
          formData.value.sort_by = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0] 
          formData.value.sort = currentSort.split('-')[1] 
          localStorage.setItem('currentSort',currentSort)
          getStudentsRanks()
      }

      
      
      function print_pdf() {
                  var tableData = document.getElementById('dataTable').innerHTML;
          var tag = document.getElementsByTagName('head')[0].innerHTML;
        var cssHead = 
          tag + `
            <img src='/school_logo/` + store.userDetails.logo + `' width=100 height=100>
            <br>` + store.userDetails.school_name 
            + `<br>` + store.userDetails.school_phone_number 
            + `<br>` + store.userDetails.school_email 
            + `<br>` + store.userDetails.school_sector 
            +`, `+ store.userDetails.school_district
            +`<br><br>
            <center>
              <h3 class='text-2xl'>Student Marks Assessment Report (${classroomDetails.value!=undefined ? classroomDetails.value.classroom_name : '' } - Term ${formData.value.term})</h3>
              <hr>
              <br><br>
            </center>`;
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
                  }, 2000);
              }

    function print_ms(type) {
          var tag = document.getElementsByTagName('head')[0].innerHTML;
          var tableData = document.getElementById('dataTable').innerHTML;
                  var contents = tag 
            + store.userDetails.school_name + `<br>` 
            + store.userDetails.school_phone_number 
            + `<br>` + store.userDetails.school_email 
            + `<br>` + store.userDetails.school_sector 
            +`, `+ store.userDetails.school_district
            + `<br><br>
            <center>
                <h3 class='text-2xl'>Student Marks Assessment Report (${classroomDetails.value!=undefined ? classroomDetails.value.classroom_name : '' } - Term ${formData.value.term})</h3>
              <hr>
              <br><br>
            </center>
             <hr>
             <br>
             <br>`;
                  contents += tableData;
                  window.open('data:application/vnd.' + type + ',' + encodeURIComponent(contents));
                  e.preventDefault();
              }

        function getStudentsRanks(){
            let currentSort = localStorage.getItem('currentSort') ?? 'name-ASC'
            formData.value.sort = currentSort.split('-')[1]
            formData.value.sort_by = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0]
            return studentsMarksStores.getStudentsSorts(formData.value)
        }
  
      onMounted(() => {
        setPageTitle(`Generate report form`)
        if(store.getUserData())
        {
          setTimeout(function (){
            currentUser.value = store.userDetails
            formData.value.account_id = store.userDetails.account_id  
            formData.value.course_id = localStorage.getItem('course_id')
            let currentSort = localStorage.getItem('currentSort') ?? 'name-ASC'
            formData.value.sort_records = currentSort
            checkAuth()
            getClassTeacherByClass()
            getStudentsRanks()
          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,selectPage,currentPage,searchStudents,clearSearch,isSorted,showPopUp,deleteAction,popupDetails,popup_type,studentsMarks,maximumPoints,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,termList,setCurrentTerm,quiz_marks,exam_marks,sortList,sortRecords,inputQuizError,inputExamError,hasValidationError,print_pdf,print_ms}
    }
  }
  </script>
  