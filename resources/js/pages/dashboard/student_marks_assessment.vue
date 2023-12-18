
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
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg> &nbsp;&nbsp;Classroom Marks Assessment Report
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

          <p class="text-sm md:text-md font-semibold text-left mt-2 pl-2">entries</p>
          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Select Term:</p>
          <select  name='select_user_role' @change="setCurrentTerm()"  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000] mt-1  md:enabled:p-2 enabled:font-light md:ml-4 " v-model="formData.term">
            <option v-for="term in termList" :value="term.term_no">
              {{ term.term_name }}
            </option>
          </select>


          <div class="hidden md:block border-l-[4px] -mt-1 ml-8 mr-14"></div>
          <p class="ml-10 md:ml-2 text-sm md:text-md font-semibold text-left mt-2 pr-2">Sort Records:</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light mt-1 md:ml-4 "  v-model="formData.sort_records" @change="sortRecords()">
                    <option v-for="sort in sortList" :value="sort.sort">{{ sort.sort_name }}</option>
          </select>
          </div>

            
<!-- 
          <input type="hidden" v-set="firstItem = 0">
          <input type="hidden" v-set="lastItem = 0"> -->

          

         <template v-if="studentsMarks.Marks?.length">
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
                <input type="hidden" :set="total_maximum1 = 0">
                <input type="hidden" :set="total_maximum2 = 0">
                <input type="hidden" :set="total_maximum3 = 0">

                <th scope="col" class="px-4 md:px-6 py-3 border" v-for="course in getCoursesList">
                    {{ course.course_name }} 
                      <input type="hidden" :set="total_maximum1 +=(course.maximum['term1_quiz'] + course.maximum['term1_exam'])">
                      <input type="hidden" :set="total_maximum2 +=(course.maximum['term2_quiz'] + course.maximum['term2_exam'])">
                      <input type="hidden" :set="total_maximum3 +=(course.maximum['term3_quiz'] + course.maximum['term3_exam'])">
                   
                      <font v-if="formData.term==1">
                        (/{{  course.maximum['term1_quiz'] + course.maximum['term1_exam']  }})
                    </font>
                    <font v-else-if="formData.term==2">
                        (/{{  course.maximum['term2_quiz'] + course.maximum['term2_exam']  }})
                    </font>
                    <font v-else>
                        (/{{  course.maximum['term3_quiz'] + course.maximum['term3_exam']  }})
                    </font>
                 </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                  Total (/{{ formData.value ==1 ? total_maximum1 : (formData.value ==2 ? total_maximum2 : total_maximum3)   }})

                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                   %
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                   Rank
                </th>
            </tr>
        </thead>
        <tbody v-if="studentsMarks.Marks?.length">
         

          <tr v-for="student,i in studentsMarks.Marks">

            <td class="px-4 md:px-6 py-4 border">
                     {{ i+studentsMarks.offset+1}}
            </td>
            <td class="px-4 md:px-6 py-4 border">
                     {{ student.name }}
            </td>
            <input type="hidden" :set="total_quiz_exam1 = 0">
            <input type="hidden" :set="total_quiz_exam2 = 0">
            <input type="hidden" :set="total_quiz_exam3 = 0">

            <td class="px-4 md:px-6 py-4 border" v-for="course,i in student.courses">
              <input type="hidden" :set="total_quiz_exam1 +=course.term1_total_marks ">
              <input type="hidden" :set="total_quiz_exam2 +=course.term2_total_marks ">
              <input type="hidden" :set="total_quiz_exam3 +=course.term3_total_marks ">

              <input type="hidden" :set="total_percentage1 = (total_quiz_exam1 / total_maximum1) * 100">
              <input type="hidden" :set="total_percentage2 = (total_quiz_exam2 / total_maximum2) * 100 ">
              <input type="hidden" :set="total_percentage3 = (total_quiz_exam3 / total_maximum3) * 100 ">
              
            <template  v-if="formData.term==1">
              {{ course.term1_total_marks }} 
            </template>
            <template v-else-if="formData.term==2">
                {{ course.term2_total_marks }} 
            </template>
            <template  v-else>
                {{ course.term3_total_marks }} 
            </template>
            </td>
            <td class="px-4 md:px-6 py-4 border">
              <dt v-if="formData.term ==1">{{ total_quiz_exam1  }}  </dt>
              <dt v-else-if="formData.term ==2">{{ total_quiz_exam2  }}</dt>
              <dt v-else="formData.term ==1">{{ total_quiz_exam3  }}</dt>
            </td>
            <td class="px-4 md:px-6 py-4 border">
              <dt v-if="formData.term ==1">{{ total_percentage1.toFixed(1)  }}%  </dt>
              <dt v-else-if="formData.term ==2">{{ total_percentage2.toFixed(1)  }}%</dt>
              <dt v-else="formData.term ==3">{{ total_percentage3.toFixed(1) }}%</dt>
            </td>
            <td class="px-4 md:px-6 py-4 border">
              <dt v-if="formData.term ==1">{{ student.rank_term1 }}/{{ studentsMarks.no_of_students  }}  </dt>
              <dt v-else-if="formData.term ==2">{{ student.rank_term2 }}/{{ studentsMarks.no_of_students  }}</dt>
              <dt v-else="formData.term ==1">{{ student.rank_term3 }}/{{ studentsMarks.no_of_students  }}</dt>
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
  import { coursesStore } from '../../stores/courses'
  import {studentsMarksStore} from '../../stores/student_marks'

  export default {
      name:"studentsMarksAssessmentReport",
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
      const coursesstores = coursesStore()
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
        },
        {
          'sort':'rank_term-ASC',
          'sort_name':'Rank (First-Last)'
        },
        {
          'sort':'rank_term-DESC',
          'sort_name':'Rank (Last-First)'
        },
      ])

      const inputQuizError = ref([])
      const inputExamError = ref([])
      const hasValidationError = ref([])
      let errorStatus =ref("")


      let getQuizMaximum = ref(localStorage.getItem('quiz_maximum'))

      const formData = ref({
              student_name:"",
              student_id:"",
              school_id:"",
              class_id:ref(route.params.class_id),
              page:1,
              account_id:"",
              course_id:uiStore.popupDetails.course_id ?? localStorage.getItem('course_id'),
              limit:localStorage.getItem('numRows') ?? 10,
              sort_by:'ASC',
              sort:'name',
              term:localStorage.getItem('selectedTerm') ?? termList.value[0].term_no,
              term_quiz:0,
              term_exam:0,
              sort_records:sortList.value[0].sort,
              maximumPoints:{
              }
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
        return studentsMarksStores.studentsMarks
      })
  
      const isLoading = computed (() => {
        return studentsMarksStores.loadingUI.isLoading
      })
  
      watch(route,() => {
        formData.value.class_id = route.params.class_id
        getStudentMarksAssessment()
        courseList()
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

      getQuizMaximum = computed(() => {
        return studentsMarksStores.quiz_maximum
      })
  
      function deleteAction(){
        formData.value.student_id = uiStore.popupDetails.popup_data.student_id
        uiStore.openPopUpFunc() // Close popup
        return studentsStores.deleteStudent(formData.value)
      }
  
      function checkAuth(){
            console.log(currentUser.value)
            if(store.userDetails != undefined){
              if(!store.userDetails.authentications?.includes('teacher'))
              {
                router.push('/dashboard/home')
              }
            }
        }

        function getCoursesOfTeacherInClass(data){
           return coursesstores.getCoursesOfTeacherInClass(data)
        }

          
       function setNumberOfRecords(){
          localStorage.setItem('numRows',formData.value.limit)
          getStudentMarksAssessment()
          courseList()
       }

       function selectPage(num,noOfPages){
          if(num <= noOfPages && num>0) 
          {
            formData.value.page = num
            currentPage.value = num
            getStudentMarksAssessment()
          }
       }

        function importStudents(){
            return studentsMarksStores.importStudentMarks(formData.value);
        }

        function getMaximum(){
          return studentsMarksStores.getMaximumPoints(formData.value);
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
             return getStudentMarksAssessment()
           }
        }

        function setCurrentTerm(){
          formData.value.term = event.target.value
          localStorage.setItem('selectedTerm',formData.value.term)
          getCoursesOfTeacherInClass(formData.value)
          getStudentMarksAssessment()
          courseList()
        }

        function sortRecords(){
          let currentSort = event.target.value
          formData.value.sort = currentSort.split('-')[0] =='rank_term'?currentSort.split('-')[0]+formData.value.term:currentSort.split('-')[0] 
          formData.value.sort_by = currentSort.split('-')[1] 
          localStorage.setItem('currentSort',currentSort)
          getStudentMarksAssessment()
          courseList()
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

        function courseList(){
            let school_id = store.userDetails.school_id
            let page = formData.value.page
            let class_id = route.params.class_id;
            let limit = 'none'
            return coursesstores.getcoursesList(school_id,class_id,page,limit)
        }

        function getStudentMarksAssessment(){
          console.log(formData.value)
            return studentsMarksStores.getStudentMarksAssessment(formData.value)
        }

        const getCoursesList = computed(() => {
            return coursesstores.coursesList.Courses
        });
  
      onMounted(() => {
        setPageTitle(`Students Assessment sheet`)
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
            getMaximum()
            courseList()
            getStudentMarksAssessment()
          },500);
          
        }
      });
  
      return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,selectPage,currentPage,searchStudents,clearSearch,isSorted,showPopUp,deleteAction,popupDetails,popup_type,getCoursesList,importStudents,studentsMarks,maximumPoints,errorStatus,successStatus,closeFeedback,successFeedbackStatus,errorFeedbackStatus,termList,getQuizMaximum,setCurrentTerm,quiz_marks,exam_marks,sortList,sortRecords,inputQuizError,inputExamError,hasValidationError,print_pdf,print_ms,courseList}
    }
  }
  </script>
  