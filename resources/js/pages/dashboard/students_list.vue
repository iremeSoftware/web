
<template >
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
              </svg> &nbsp;&nbsp;Manage Students ({{ classroomDetails.classroom_name }})

          </p>
      </div>
      <div class=" md:ml-[19%] mt-10  w-full  shadow-lg bg-[#ffffff] rounded-2xl">
        
        <div class="flex w-full ">
          <div class="flex p-6 w-4/12 text-xs md:text-sm">
          <p class=" font-semibold text-left mt-2 pr-2">Show:</p>
          <select @change="setNumberOfRecords()"  name='select_user_role' v-model="formData.limit" class="h-6 md:h-9  rounded-lg bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light " id="formData.select_user_role">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>
        <p class="text-sm font-semibold text-left mt-2 pl-2">entries</p>
        </div>

        <div class="w-2/12 md:w-6/12"></div>
         <div class="flex p-6 md:w-4/12 text-end text-xs md:text-sm">
          <p class="font-semibold mt-2 pr-2"> </p>
          <input type="text" class="w-full mt-1 h-[28px] md:h-10 ring-1 ring-[#000000] rounded-tl rounded-bl placeholder:p-1 placeholder:font-light  enabled:p-2" @keyup="clearSearch()" placeholder="Search student here" v-model="formData.student_name">
          <button @click="searchStudents()" class="w-12 h-[30px] md:h-[42px] mt-[3px] text-sm text-white bg-[#000000] rounded-tr rounded-br"><p class="flex pl-2 pt-[1px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            </p></button>
        </div>
        </div>
      <div class="p-6">
       <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-xs md:text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                </th>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Student ID
                </th>
                <th scope="col" class="flex px-6 py-3">
                    Names 
                    <button type="button" @click="sortRecords()" class="ml-2 pl-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75L12 3m0 0l3.75 3.75M12 3v18" /></svg></button>
                    <button type="button" @click="sortRecords()"  class="-ml-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
</svg></button>

                </th>
                <th scope="col" class="px-6 py-3">
                    Sex
                </th>
                <th scope="col" class="px-6 py-3">
                    Father's name
                </th>
                <th scope="col" class="px-6 py-3">
                    Mother's name
                </th>
                <th scope="col" class="px-6 py-3">
                    Father's phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Mother's phone
                </th>
                <!-- <th scope="col" class="px-6 py-3">
                    Parent email
                </th> -->
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <input type="hidden" v-set="firstItem = 0">
        <input type="hidden" v-set="lastItem = 0">
        <tbody v-if="studentsList.Students">
            <tr v-for="(student,i) in studentsList.Students" :key="student.id" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <input type="checkbox">
                </th>
                <input v-if="i==0" type="hidden" v-set="firstItem = (i + studentsList.offset) +1">

                <input  type="hidden" v-set="lastItem = (i + studentsList.offset) +1">

                <td class="px-6 py-4">
                   {{ (i + studentsList.offset)+1}}
                </td>
                <td class="px-6 py-4">
                    {{student.student_id}}
                </td>
                <td class="px-6 py-4">
                    {{student.name}}
                </td>
                <td class="px-6 py-4">
                    {{student.student_sex}}
                </td>
                <td class="px-6 py-4">
                    {{student.fathers_name}}
                </td>
                <td class="px-6 py-4">
                    {{student.mothers_name}}
                </td>
                <td class="px-6 py-4">
                    {{student.fathers_phone}}
                </td>
                <td class="px-6 py-4">
                    {{student.mothers_phone}}
                </td>
                <!-- <td class="px-6 py-4">
                    {{student.parent_email}}
                </td> -->
                <td class="flex px-6 py-4">
                  <a href="#" class="font-medium pr-3 text-blue-600 dark:text-blue-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                </a>
                <a href="#" class="font-medium text-red-600 dark:text-blue-500 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
        <div class="flex w-full text-xs md:text-sm ">
          <div class="flex pl-1 pt-6 w-5/12 hidden md:block">
          <p class="text-sm font-semibold text-left mt-2 pr-2">Show {{ firstItem }} to {{ lastItem }} of {{ studentsList.no_of_students }} students</p>
         </div>

         <div class="w-2/12 md:w-6/12"></div>
         <input v-set="noOfPages = Math.ceil(studentsList.no_of_students / numRows)" type="hidden">
         <div v-if="studentsList.no_of_students" class="flex pt-6 text-end">
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
        </div>

        <div class="flex w-full text-xs md:text-sm pt-4 ">
          <p class="text-left mt-2 pl-1">Select column to hide</p>
          <select  name='select_user_role'  class="h-6 md:h-9  rounded-lg  bg-transparent ring-1 ring-[#000000]  md:enabled:p-2 enabled:font-light ml-4 ">
            <option>Student Id</option>
            <option>Sex</option>
            <option>Classroom</option>
            <option>Father's name</option>
            <option>Mother's name</option>
            <option>Father's phone</option>
            <option>Mother's phone</option>
            <option>Father ID</option>
            <option>Mother ID</option>
            <option>District</option>
            <option>Sector</option>
            <option>Cell</option>
            <option>Village</option>
        </select>

        </div>

<div v-if="isLoading" class="absolute top-[60%] left-[50%]">
                    <svg class="animate-spin text-black h-14 w-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" ></circle><path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div> 
              </div>
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
import { useRouter,useRoute } from 'vue-router'
import { classroomStore } from '../../stores/classroom'
import { studentsStore } from '../../stores/students'

export default {
    name:"studentsPage",
    components:{
      Alert,
      Header2,
      sidebarVue
   },
  setup() {
    const store = useUserStore()
    const currentUser = ref([])
    const route = useRoute()
    const classroomStores = classroomStore()
    const studentsStores = studentsStore()
    const numRows = ref(localStorage.getItem('numRows'))
    const currentPage = ref(1)
    const isSorted = ref(false)

    const formData = ref({
            student_name:"",
            school_id:"",
            class_id:"",
            student_id:'null',
            page:1,
            limit:localStorage.getItem('numRows') ?? 10,
            sort:'name',
            sort_by:'ASC'
        });


    const getUsers = computed(() => {
      currentUser.value = store.userDetails
     return currentUser.value;
    });

    function setPageTitle(newTitle){
      if (document.title != newTitle) {
          document.title = ""
          document.title = import.meta.env.VITE_APP_NAME +' - '+ newTitle
      }
    }

    const classroomDetails = computed (() => {
      return classroomStores.classroomDetails
    })

    const studentsList = computed (() => {
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
        numRows.value = event.target.value
        formData.value.limit = numRows.value
        localStorage.setItem('numRows',numRows.value)
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
     
    onMounted(() => {
      setPageTitle(`Students (${classroomDetails})`)
      if(store.getUserData())
      {
        setTimeout(function (){
          currentUser.value = store.userDetails
          getClassTeacherByClass()
          getStudentList()
        },500);
        
      }
    });

    return {currentUser,getUsers,classroomDetails,studentsList,setNumberOfRecords,formData,isLoading,numRows,selectPage,currentPage,searchStudents,getStudentList,clearSearch,sortRecords,isSorted}
  }
}
</script>
