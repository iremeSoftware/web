
<template >
  <template v-if="popup_type =='delete'">
    <confirmationPrompt :popupDetails="popupDetails" :popupAction="deleteAction" />
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 mt-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg> &nbsp;&nbsp;List of courses

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
          <input type="text" class="w-full mt-1 h-[28px] md:h-10 ring-1 ring-[#000000] rounded-tl rounded-bl placeholder:p-1 placeholder:font-light  enabled:p-2" @keyup="clearSearch()" placeholder="Search course here" v-model="formData.search_query">
          <button @click="searchCourse()" class="w-12 h-[30px] md:h-[42px] mt-[3px] text-sm text-white bg-[#000000] rounded-tr rounded-br"><p class="flex pl-2 pt-[1px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            </p></button>
        </template>
        <template v-slot:columnsToShow>
          
        </template>
        <template v-slot:table>
          <div class="flex" @mousemove="hideCols(false)">
        <div class="w-full overflow-x-auto shadow-md sm:rounded-lg" id="dataTable" >
        <table class="w-full text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class=" text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    #
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Course name
                </th>
                <th scope="col" class="px-4 md:px-6 py-3 border">
                    Course Id
                </th>
               
                <th scope="col" class="px-4 md:px-6 py-3 md:text-center colToHide border ">
                    Action
                </th>
            </tr>
        </thead>
        <input type="hidden" v-set="firstItem = 0">
        <input type="hidden" v-set="lastItem = 0">
        <tbody v-if="getCoursesList.Courses?.length > 0" >
            <tr v-for="(course,i) in getCoursesList.Courses" :key="course.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700 ">
                <input v-if="i==0" type="hidden" v-set="firstItem = (i + getCoursesList.offset) +1">
                <input  type="hidden" v-set="lastItem = (i + getCoursesList.offset) +1">
                <td class="px-4 md:px-6 py-4 border">
                   {{ i + getCoursesList.offset +1}}
                </td>
                <td class="px-4 md:px-6 py-4 border">
                   {{ course.course_name}}
                </td>
                <td class="px-4 md:px-6 py-4 border">
                   {{ course.course_id }}
                </td>
                <td class="flex px-4 md:px-6 py-4 colToHide space-x-2 md:space-x-20 ">
                  <a href="#" @click="showPopUp('update_course','','','',course)" class="flex md:w-[100px] h-8 text-sm rounded-lg md:text-white md:bg-[#000000]" ><p class="flex pl-3 pt-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg> <font class="hidden md:block pt-1">Edit</font></p>
                </a>
                <a href="#" class="flex md:w-[100px] h-8 text-sm rounded-lg md:text-white md:bg-[#000000] pt-1 pl-2" @click="
                showPopUp('delete','','Confirmation Alert','Are you sure you want to delete course and its linked data completely?',
                {
                  'course_id':course.course_id
                })"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>

                <font class="hidden md:block pt-1">Delete</font>
                </a>
                </td>

            </tr>
        </tbody>
        <tbody v-else>
                  <td colspan="9" class="h-20">
                      <h3 class="text-lg text-center">No courses found</h3>
                  </td>
        </tbody>
        </table>
        </div>
        </div>
</template>
<template v-slot:entries>
  Show {{ firstItem }} to {{ lastItem }} of {{ getCoursesList.no_of_courses }} courses
</template>
<template v-slot:pagination>
  <div v-if="getCoursesList.no_of_courses" class="flex pt-6 text-end">
          <input v-set="noOfPages = Math.ceil(getCoursesList.no_of_courses / formData.limit)" type="hidden">
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
<template v-slot:printBtns>
  <div class="flex text-xs md:text-sm space-x-4" @mousemove="hideCols(true)" >
          <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md ring-2 ring-black" @click="print_pdf"><p class="flex pl-2  space-x-2">
            <svg viewBox="0 0 384 512" class="w-6 h-6 bg-white" xmlns="http://www.w3.org/2000/svg"><path  d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48zm250.2-143.7c-12.2-12-47-8.7-64.4-6.5-17.2-10.5-28.7-25-36.8-46.3 3.9-16.1 10.1-40.6 5.4-56-4.2-26.2-37.8-23.6-42.6-5.9-4.4 16.1-.4 38.5 7 67.1-10 23.9-24.9 56-35.4 74.4-20 10.3-47 26.2-51 46.2-3.3 15.8 26 55.2 76.1-31.2 22.4-7.4 46.8-16.5 68.4-20.1 18.9 10.2 41 17 55.8 17 25.5 0 28-28.2 17.5-38.7zm-198.1 77.8c5.1-13.7 24.5-29.5 30.4-35-19 30.3-30.4 35.7-30.4 35zm81.6-190.6c7.4 0 6.7 32.1 1.8 40.8-4.4-13.9-4.3-40.8-1.8-40.8zm-24.4 136.6c9.7-16.9 18-37 24.7-54.7 8.3 15.1 18.9 27.2 30.1 35.5-20.8 4.3-38.9 13.1-54.8 19.2zm131.6-5s-5 6-37.3-7.8c35.1-2.6 40.9 5.4 37.3 7.8z"/></svg>
            <font class="pt-1">Print PDF</font></p>
          </button>

          <button class="w-44 h-8 md:h-10 text-xs md:text-sm rounded-md  bg-transparent ring-2 ring-black"  @click="print_ms('ms-excel')"><p class="flex pl-2  space-x-2">
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
import { coursesStore } from '../../stores/courses'
import {setPageTitle} from '../../helpers/set_page_title'




export default {
    name:"coursesList",
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
    const coursesstores = coursesStore()
    const userStore = useUserStore()

    const formData = ref({
        search_query:"",
        school_id:"",
        class_id:ref(route.params.class_id),
        student_id:'null',
        page:1,
        limit:localStorage.getItem('numRows') ?? 10,
        sort:'course_name',
        sort_by:'ASC'
    });


    const getUsers = computed(() => {
      currentUser.value = store.userDetails
     return currentUser.value;
    });


    const isLoading = computed (() => {
      return studentsStores.loadingUI.isLoading
    })

    const popup_type = computed(() => uiStore.popup_type);


    watch(route,() => {
      getClassTeacherByClass()
      courseList()
     })

     function getClassTeacherByClass(){
       return classroomStores.getClassTeacherByClass(currentUser.value.school_id,route.params.class_id)
     }

     function setNumberOfRecords(){
        formData.value.page = 1
        localStorage.setItem('numRows',formData.value.limit)
        courseList()
     }

     function sortRecords()
     {
       isSorted.value =! isSorted.value
       formData.value.sort_by = isSorted.value ? 'DESC' : 'ASC'
       return courseList()
     }

     function searchCourse (){
      if(formData.value.search_query.length >2)
      {
        let school_id = userStore.userDetails.school_id
        let search_query = formData.value.search_query
        return coursesstores.searchCourse(school_id,search_query)
      }
     }

     function clearSearch(){
         if(event.which == 8)
         {
           return courseList()
         }
     }

     function selectPage(num,noOfPages){
        if(num <= noOfPages && num>0) 
        {
          formData.value.page = num
          currentPage.value = num
          courseList()
        }
     }


     function courseList(){
            let school_id = userStore.userDetails.school_id
            let page = formData.value.page
            let limit = formData.value.limit
            return coursesstores.getcoursesList(school_id,"",page,limit)
        }

    const getCoursesList = computed(() => {
            return coursesstores.coursesList
        })

    let isMenuClicked = computed(() => uiStore.isMenuClicked);




    function showPopUp(popup_type,to='',popup_title='',popup_message='',popup_data = {}){
      let popup_records = {
        'popup_title':popup_title,
        'popup_message':popup_message,
        'popup_data':popup_data,
      }

      formData.value.course_id = popup_data.course_id
      console.log(popup_records)
      toggleSideBar()
      return uiStore.openPopUpFunc(popup_type,to,popup_records);    
    }

    function toggleSideBar(){
        isMenuClicked =! isMenuClicked
        return uiStore.isLeftMenuSelected(isMenuClicked)         
    }

    const popupDetails = computed(() => uiStore.popupDetails)

    function deleteAction(){
      let school_id = userStore.userDetails.school_id
      uiStore.openPopUpFunc() // Close popup
      return coursesstores.deleteCourse(school_id,formData.value)
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
            <h3 class='text-2xl'>Courses list</h3>
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
            <h3 class='text-2xl'>Courses list</h3>
           </center>
           <hr>
           <br>
           <br>`;
				contents += tableData;
				window.open('data:application/vnd.' + type + ',' + encodeURIComponent(contents));
				e.preventDefault();
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

    function checkAuth(){
          console.log(currentUser.value)
          if(store.userDetails != undefined){
            if(!store.userDetails.authentications?.includes('add_course'))
            {
              router.push('/dashboard/home')
            }
          }
      }
     
     
    onMounted(() => {
      setPageTitle(`List of courses`)
      if(store.getUserData())
      {
        setTimeout(function (){
          checkAuth()
          currentUser.value = store.userDetails
          courseList()
        },500);
        
      }
    });

    return {currentUser,getUsers,setNumberOfRecords,isLoading,selectPage,currentPage,searchCourse,clearSearch,sortRecords,isSorted,showPopUp,deleteAction,popupDetails,print_pdf,print_ms,formData,getCoursesList,hideCols,popup_type}
  }
}
</script>
