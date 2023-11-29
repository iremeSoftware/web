
<template >
  <template v-if="popup_type =='delete' || popup_type =='migrate' ">
    <confirmationPrompt :popupDetails="popupDetails" :popupAction="popup_type =='delete'?deleteAction:migrateStudents" />
  </template>

  
  <div class="w-full flex" >
    <sidebarVue />
    <div class="w-full md:w-5/6">
      <Header2 />
      <div class="pl-2 md:pl-[20%] pt-[22%] md:pt-[8%]">
        <!-- <h1 class="text-16px md:text-3xl font-semibold text-transparent bg-clip-text bg-gradient-to-l from-[#8fcc53] to-[#0171c0]">
          👋 Welcome to {{ getUsers.school_name }}
          </h1> -->
          <p class="flex text-16px md:text-2xl font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg> &nbsp;&nbsp;Manage Students
               ({{ classroomDetails!=undefined ? classroomDetails.classroom_name : '' }})

          </p>
      </div>
      <DataTable>
        <template v-slot:no_of_records>
          <p class=" font-semibold text-left mt-2 pr-2">Show:</p>
          <select @change="setNumberOfRecords()"  name='select_user_role' v-model="formData.limit" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
        <p class="text-sm font-semibold text-left mt-2 pl-2">entries</p>
        </template>
        <template v-slot:searchInput>
          <input type="text" class="w-full mt-1 h-[28px] md:h-10 ring-1 ring-[#000000] rounded-tl rounded-bl placeholder:p-1 placeholder:font-light  enabled:p-2" @keyup="clearSearch()" placeholder="Search student here" v-model="formData.student_name">
          <button @click="searchStudents()" class="w-12 h-[30px] md:h-[42px] mt-[3px] text-sm text-white bg-[#000000] rounded-tr rounded-br"><p class="flex pl-2 pt-[1px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            </p></button>
        </template>
        <template v-slot:columnsToShow>
          <p class="text-left mt-2 ">Select column to show</p>
        <select  name='select_user_role' @change="selectColsToShow()"  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light ml-4 ">
          <option value="">--Select--</option>
          <option value="student_id">Student Id</option>
          <option value="student_sex">Sex</option>
          <option value="classroom">Classroom</option>
          <option value="fathers_name">Father's name</option>
          <option value="mothers_name">Mother's name</option>
          <option value="mothers_phone">Mother's phone</option>
          <option value="fathers_phone">Mother's phone</option>
          <option value="priority_phone">Primary phone</option>
          <option value="parent_email">Primary Email</option>
          <option value="fathers_ID">Father's ID No</option>
          <option value="mothers_ID">Mother's ID No</option>
          <option value="location_district">District</option>
          <option value="location_sector">Sector</option>
          <option value="location_cell">Cell</option>
          <option value="location_village">Village</option>
        </select>

        <div class="flex md:flex-wrap  pl-4 pt-2 md:pt-0  h-auto overflow-x-auto md:overflow-x-0">
          <button class="w-auto h-6 md:h-8 text-xs md:text-sm rounded-2xl text-white bg-[#000000] ml-2 md:mt-2" v-for="col,i in colsToShow" @click="removeCol(i)"><p class="flex pl-8 truncate">
            <font>{{ col.value }}</font><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg></p>
          </button>
        </div>
        </template>
<template v-slot:table>
  <div class="overflow-x-auto shadow-md sm:rounded-lg" id="dataTable" @mousemove="hideCols(false)">
        <table class="w-full border text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="border px-6 py-3 colToHide">
                </th>
                <th scope="col" class="border px-6 py-3">
                    #
                </th>
                <th scope="col" class="border px-6 py-3" v-for="col in colsToShow" :class="col.key == 'name'?'flex':''">
                   {{ col.value }}

                   <button type="button" v-if="col.key == 'name'" @click="sortRecords()" class="flex ml-2 pl-2 colToHide">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" :class="isSorted ? 'text-red-500':''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" /></svg>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 -ml-2" :class="isSorted == false ? 'text-red-500':''">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
                     </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3 colToHide">
                    Action
                </th>
            </tr>
        </thead>
        <input type="hidden" v-set="firstItem = 0">
        <input type="hidden" v-set="lastItem = 0">
        <tbody  v-if="studentsList.Students?.length > 0">
            <tr v-for="(student,i) in studentsList.Students" :key="student.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white colToHide border">
                    <input type="checkbox" v-model="studentIds" @click="select" :value="student.student_id">
                </th>
                <input v-if="i==0" type="hidden" v-set="firstItem = (i + studentsList.offset) +1">
                <input  type="hidden" v-set="lastItem = (i + studentsList.offset) +1">
                <td class="px-6 py-4 border">
                   {{ (i + studentsList.offset)+1}}
                </td>
                <td class="px-6 py-4 border" v-for="col in colsToShow" >
                  {{student[col.key] == 'mp' ? "Mother's phone" : student[col.key] == 'fp' ? "Father's phone":
                  (col.key =='location_district' || col.key =='location_sector' || col.key =='location_cell' || col.key =='location_village')
                  ?  student[col.key].split('_')[1] : student[col.key]  }}
                </td>
                <td class="flex px-6 py-4 colToHide">
                  <a href="#" @click="showPopUp('update_student','','','',student)" class="font-medium pr-3 text-blue-600 dark:text-blue-500 hover:underline" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                </a>
                <a href="#" class="font-medium text-red-600 dark:text-blue-500 hover:underline" @click="
                showPopUp('delete','','Confirmation Alert','Are you sure you want to delete this record?',
                {
                  'student_id':student.student_id
                })"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                </a>
                </td>
            </tr>
              </tbody>
              <tbody v-else>
                  <td colspan="9" class="h-20">
                      <h3 class="text-lg text-center">No students found</h3>
                  </td>
              </tbody>
              
            </table>
        </div>
</template>
<template v-slot:entries>
  Show {{ firstItem }} to {{ lastItem }} of {{ studentsList.no_of_students }} students
</template>
<template v-slot:pagination>
  <div v-if="studentsList.no_of_students" class="flex pt-6 text-end">
          <input v-set="noOfPages = Math.ceil(studentsList.no_of_students / formData.limit)" type="hidden">
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
  <div class="flex w-5/12 text-xs md:text-sm space-x-3">
            <input type="checkbox" id="select_all" @click="selectAll" v-model="allSelected">
          <label class=" font-semibold text-left mt-2 mr-2" for="select_all">Select All</label>
          </div>
          <div class="flex  md:w-5/12 text-xs md:text-sm space-x-3">
          <p class="text-sm font-semibold text-left mt-2">Migrate selected students to:</p>
         <select name='classroom' class="w-44 h-9 bg-transparent ring-1 ring-[#000000] rounded-lg enabled:p-2 enabled:font-light" id="formData.classroom" v-model="formData.to_class"  @change="studentIds.length && formData.to_class ?showPopUp('migrate','','Confirmation Alert','Are you sure you want to migrate selected students?'):''" >
          <option value=''>--Select classroom--</option>
          <option v-for="a in getClassroomList" :value="a.class_id" :key="a.class_id" >{{a.classroom_name}}</option>
          </select>
          </div>
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
import {setPageTitle} from '../../helpers/set_page_title'


export default {
    name:"studentsPage",
    components:{
      Alert,
      Header2,
      sidebarVue,
      confirmationPrompt,
      DataTable
   },
  setup() {
    const store = useUserStore()
    const uiStore = uiChangesStore();
    const currentUser = ref([])
    const route = useRoute()
    const router = useRouter()
    const classroomStores = classroomStore()
    const studentsStores = studentsStore()
    const currentPage = ref(1)
    const isSorted = ref(false)
    let studentsList = ref([]) 
    let classroomDetails = ref([]) 

    const selected = ref([])
    const allSelected =  ref(false)
    const studentIds = ref([])
    const colsToShow = ref([
      {
       key:'name',
       value:'Names'
      },
      {
       key:'student_sex',
       value:'Sex'
      },
      {
       key:'fathers_name',
       value:"Father's name"
      },
      {
       key:'mothers_name',
       value:"Mother's name"
      },
      {
       key:'mothers_phone',
       value:"Mother's phone"
      },
      {
       key:'fathers_phone',
       value:"Father's phone"
      }
    ])


    const formData = ref({
            student_name:"",
            school_id:"",
            class_id:ref(route.params.class_id),
            student_id:'null',
            from_class:'null',
            to_class:'null',
            page:1,
            limit:localStorage.getItem('numRows') ?? 10,
            sort:'name',
            sort_by:'ASC'
    });
    


    const getUsers = computed(() => {
      currentUser.value = store.userDetails
     return currentUser.value;
    });



    classroomDetails = computed (() => {
      return classroomStores.classroomDetails
    })

    studentsList = computed (() => {
      return studentsStores.studentsList
    })

    const isLoading = computed (() => {
      return studentsStores.loadingUI.isLoading
    })

    watch(route,() => {
      getClassTeacherByClass()
      getStudentList()
     })

     function getClassTeacherByClass(){
       return classroomStores.getClassTeacherByClass(currentUser.value.school_id,route.params.class_id)
     }

     function setNumberOfRecords(){
        localStorage.setItem('numRows',formData.value.limit)
        getStudentList()
     }

     function sortRecords()
     {
       isSorted.value =! isSorted.value
       formData.value.sort_by = isSorted.value ? 'DESC' : 'ASC'
       return getStudentList()
     }

     function searchStudents (){
      if(formData.value.student_name.length >2)
      {
        return studentsStores.searchStudent(formData.value)
      }
     }

     function clearSearch(){
         if(event.which == 8)
         {
           return getStudentList()
         }
     }

     function selectPage(num,noOfPages){
        if(num <= noOfPages && num>0) 
        {
          formData.value.page = num
          currentPage.value = num
          getStudentList()
        }
     }

     function getStudentList(){
        formData.value.school_id = currentUser.value.school_id
        formData.value.class_id = route.params.class_id
        return studentsStores.getStudentList(formData.value)
     }

      function selectAll() {
        studentIds.value = [];
        if (allSelected.value == false) {
            for (var i=0 ; i<=studentsStores.studentsList.Students.length-1;i++) {
                studentIds.value.push(studentsStores.studentsList.Students[i]['student_id'].toString());
            }
        }
    }

    function select() {
        allSelected.value = false;
    }

    const getClassroomList = computed(() => {
            return classroomStores.classroomList.classrooms;
    });

    let isMenuClicked = computed(() => uiStore.isMenuClicked);

    const popup_type = computed(() => uiStore.popup_type);



    function showPopUp(popup_type,to='',popup_title='',popup_message='',popup_data = {}){
      let popup_records = {
        'popup_title':popup_title,
        'popup_message':popup_message,
        'popup_data':popup_data,
      }
      toggleSideBar()
      return uiStore.openPopUpFunc(popup_type,to,popup_records);    
    }

    function toggleSideBar(){
        isMenuClicked =! isMenuClicked
        return uiStore.isLeftMenuSelected(isMenuClicked)         
    }

    const popupDetails = computed(() => uiStore.popupDetails)

    function deleteAction(){
      formData.value.student_id = uiStore.popupDetails.popup_data.student_id
      uiStore.openPopUpFunc() // Close popup
      return studentsStores.deleteStudent(formData.value)
    }

    function migrateStudents(){
      formData.value.from_class = route.params.class_id
      formData.value.student_id = studentIds.value.toString()
      uiStore.openPopUpFunc() // Close popup
      return studentsStores.moveStudents(formData.value)
    }

    function selectColsToShow(){
      if(event.target.value)
          colsToShow.value.push(
          {
            key:event.target.value,
            value:event.target.selectedOptions[0].text
          }
        )
        function getUniqueListBy(arr, key) {
              return [...new Map(arr.map(item => [item[key], item])).values()]
        }
        colsToShow.value = getUniqueListBy(colsToShow.value, 'key')
    }

    function removeCol(index){
      if(colsToShow.value.length > 6 && colsToShow.value[index].key !='name' )
        colsToShow.value.splice(index, 1); // 2nd parameter means remove one item only
      else
        alert("You can't remove remaining columns")  
    }

    function hideCols(action){
      let countCols = document.getElementsByClassName('colToHide')
      if(action)
      {
        for (var i=0 ; i<=countCols.length; i++)
          document.getElementsByClassName('colToHide')[i].style.display = 'none'
      }
      else{
        for (var i=0 ; i<=countCols.length; i++)
          document.getElementsByClassName('colToHide')[i].style.display = ''
      }
    }

    function print_pdf() {
				var tableData = document.getElementById('dataTable').innerHTML;
        var tag = document.getElementsByTagName('head')[0].innerHTML;
				var cssHead = 
        tag + `
          <img src='/school_logo/` + store.userDetails.logo + `' width=100 height=100>
          <br>` + store.userDetails.school_name 
          + `<br>` + store.userDetails.school_phone_number 
          + `<br>` + store.userDetails.school_sector 
          +`, `+ store.userDetails.school_district
          +`<br><br>
          <center>
            <h3 class='text-2xl'>Students of `+classroomStores.classroomDetails.classroom_name+`</h3>
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
			//################################//PRINT PDF#############################################
			//################################PRINT EXCEL FILE########################################
			function print_ms(type) {
        document.getElementsByClassName('colToHide')[0].style.display = 'none'
        var tag = document.getElementsByTagName('head')[0].innerHTML;
        var tableData = document.getElementById('dataTable').innerHTML;
				var contents = tag 
          + store.userDetails.school_name + `<br>` 
          + store.userDetails.school_phone_number 
          + `<br>` + store.userDetails.school_sector 
          +`, `+ store.userDetails.school_district
          + `<br><br>
           <center>
            <h3 class='text-2xl'>Students of `+classroomStores.classroomDetails.classroom_name+`</h3>
           </center>
           <hr>
           <br>
           <br>`;
				contents += tableData;
				window.open('data:application/vnd.' + type + ',' + encodeURIComponent(contents));
				e.preventDefault();
			}

      function checkAuth(){
          console.log(currentUser.value)
          if(store.userDetails != undefined){
            if(!store.userDetails.authentications?.includes('manage_students'))
            {
              router.push('/dashboard/home')
            }
          }
      }
     
     
    onMounted(() => {
      setPageTitle(`Students (${classroomStores.classroomDetails.classroom_name})`)
      if(store.getUserData())
      {
        setTimeout(function (){
          currentUser.value = store.userDetails
          checkAuth()
          getClassTeacherByClass()
          getStudentList()
          classroomStores.getClassroomList(store.userDetails.school_id)
        },500);
        
      }
    });

    return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,selectPage,currentPage,searchStudents,getStudentList,clearSearch,sortRecords,isSorted,selectAll,select,allSelected,studentIds,selected,getClassroomList,showPopUp,deleteAction,popupDetails,migrateStudents,popup_type,colsToShow,selectColsToShow,removeCol,print_pdf,print_ms,hideCols}
  }
}
</script>
