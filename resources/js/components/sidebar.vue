<template>
    <div class="md:block fixed w-[20%] md:w-[15%] h-full  shadow-md bg-white " :class="isMenuClicked ? 'block w-[40%]':'hidden'">
      <div class=" pl-2 pt-12 md:pt-2">
        <router-link to="/dashboard/home" class="hidden pb-2 md:block shadow-sm -pr-2">
                <img class=" w-[80px] h-[40px] " src="https://www.iremeapp.com/logo/logo.png" />
          </router-link>
          <div class="overflow-y-auto">  

          <LeftSideMenu>
            <template v-slot:icon>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" clip-rule="evenodd" d="M3.58579 10.4142C3.21071 10.7892 3 11.2979 3 11.8284V20C3 20.5522 3.44772 21 4 21H10C10.5523 21 11 20.5522 11 20V15H13V20C13 20.5522 13.4477 21 14 21H20C20.5523 21 21 20.5522 21 20V11.8284C21 11.2979 20.7893 10.7892 20.4142 10.4142L13.4142 3.41416C12.6332 2.63311 11.3668 2.63311 10.5858 3.41416L3.58579 10.4142ZM11 14C10.4477 14 10 14.4477 10 15V20H4V11.8284C4 11.5631 4.10536 11.3088 4.29289 11.1213L11.2929 4.12126C11.6834 3.73074 12.3166 3.73074 12.7071 4.12126L19.7071 11.1213C19.8946 11.3088 20 11.5632 20 11.8284V20H14V15C14 14.4477 13.5523 14 13 14H11Z" fill="black"/>
              </svg>
            </template>
            <template v-slot:menu>
              <routerLink to="/dashboard/home" @click="toggleSideBar()">
                <p class="pt-1 w-[20%]">Dashboard</p>
              </routerLink>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg>

            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[20%]"> Students</p>
            </template>
            <template v-slot:submenu>
              <div class="flex py-2" @click="showPopUp('add_student')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> Add students</a></div>

              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('classroomList','/dashboard/students')"> Students list</a></div>

              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('classroomList','/dashboard/attendance')"> Student Attendance</a></div>

              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('classroomList','/dashboard/report_form')"> Student report forms</a></div>

            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[20%]">Classrooms</p>
            </template>
            <template v-slot:submenu>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('createClassroom')"> Add classroom</a></div>
              
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> Classrooms settings</a></div>
            </template>
          </LeftSideMenu>


          <LeftSideMenu>
            <template v-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[20%]">Courses</p>
            </template>
            <template v-slot:submenu>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('createCourses')"> Add new course</a></div>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> List of courses</a></div>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> Modify courses</a></div>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>

            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[20%]">Users</p>
            </template>
            <template v-slot:submenu>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#" @click="showPopUp('newUsers')"> Invite new user</a></div>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> Assign role</a></div>
              <div class="flex py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M14 13H8V5H6v9a1 1 0 0 0 1 1h7v3l5-4-5-4v3z"></path></svg><a class="pt-1" href="#"> List of users</a></div>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[20%]">Reports</p>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
              </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-full">Cloud Storage </p>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.348 14.651a3.75 3.75 0 010-5.303m5.304 0a3.75 3.75 0 010 5.303m-7.425 2.122a6.75 6.75 0 010-9.546m9.546 0a6.75 6.75 0 010 9.546M5.106 18.894c-3.808-3.808-3.808-9.98 0-13.789m13.788 0c3.808 3.808 3.808 9.981 0 13.79M12 12h.008v.007H12V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[40%]">Send SMS</p>
            </template>
          </LeftSideMenu>

          <div class="h-5"></div>
          <hr>
          <div class="h-2"></div>
          <LeftSideMenu>
            <template v-slot:icon>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0002 16C14.2094 16 16.0002 14.2091 16.0002 12C16.0002 9.79086 14.2094 8 12.0002 8C9.79109 8 8.00023 9.79086 8.00023 12C8.00023 14.2091 9.79109 16 12.0002 16ZM12.0002 15C13.6571 15 15.0002 13.6569 15.0002 12C15.0002 10.3431 13.6571 9 12.0002 9C10.3434 9 9.00023 10.3431 9.00023 12C9.00023 13.6569 10.3434 15 12.0002 15Z" fill="black"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1182 1.86489L15.5203 4.81406C15.8475 4.97464 16.1621 5.1569 16.4623 5.35898L19.2185 4.23223C19.6814 4.043 20.2129 4.2248 20.463 4.65787L22.5901 8.34213C22.8401 8.77521 22.7318 9.3264 22.3365 9.63266L19.9821 11.4566C19.9941 11.6362 20.0002 11.8174 20.0002 12C20.0002 12.1826 19.9941 12.3638 19.9821 12.5434L22.3365 14.3673C22.7318 14.6736 22.8401 15.2248 22.5901 15.6579L20.463 19.3421C20.2129 19.7752 19.6814 19.957 19.2185 19.7678L16.4623 18.641C16.1621 18.8431 15.8475 19.0254 15.5203 19.1859L15.1182 22.1351C15.0506 22.6306 14.6274 23 14.1273 23H9.87313C9.37306 23 8.94987 22.6306 8.8823 22.1351L8.48014 19.1859C8.15296 19.0254 7.83835 18.8431 7.53818 18.641L4.78195 19.7678C4.31907 19.957 3.78756 19.7752 3.53752 19.3421L1.41042 15.6579C1.16038 15.2248 1.26869 14.6736 1.66401 14.3673L4.01841 12.5434C4.00636 12.3638 4.00025 12.1826 4.00025 12C4.00025 11.8174 4.00636 11.6362 4.01841 11.4566L1.66401 9.63266C1.26869 9.3264 1.16038 8.77521 1.41041 8.34213L3.53752 4.65787C3.78755 4.2248 4.31906 4.043 4.78195 4.23223L7.53818 5.35898C7.83835 5.1569 8.15296 4.97464 8.48014 4.81406L8.8823 1.86489C8.94987 1.3694 9.37306 1 9.87313 1H14.1273C14.6274 1 15.0506 1.3694 15.1182 1.86489ZM14.6015 5.47705L15.0798 5.71177C15.3659 5.8522 15.6411 6.01165 15.9038 6.18852L16.3466 6.48661L19.5969 5.15787L21.7241 8.84213L18.9487 10.9922L18.9843 11.5236C18.9949 11.6809 19.0002 11.8397 19.0002 12C19.0002 12.1603 18.9949 12.3191 18.9843 12.4765L18.9487 13.0078L21.7241 15.1579L19.5969 18.8421L16.3466 17.5134L15.9038 17.8115C15.6411 17.9884 15.3659 18.1478 15.0798 18.2882L14.6015 18.523L14.1273 22H9.87313L9.39899 18.5229L8.92072 18.2882C8.63461 18.1478 8.35936 17.9884 8.09664 17.8115L7.65386 17.5134L4.40355 18.8421L2.27644 15.1579L5.0518 13.0078L5.01617 12.4765C5.00561 12.3191 5.00024 12.1603 5.00024 12C5.00024 11.8397 5.00561 11.6809 5.01617 11.5235L5.0518 10.9922L2.27644 8.84213L4.40355 5.15787L7.65386 6.4866L8.09664 6.18851C8.35936 6.01165 8.63461 5.8522 8.92072 5.71178L9.39899 5.47705L9.87313 2L14.1273 2L14.6015 5.47705Z" fill="black"/>
                    </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[30%]">Settings</p>
            </template>
          </LeftSideMenu>

          <LeftSideMenu>
            <template v-slot:icon>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.6919 14.1359C11.4498 14.1359 11.2532 13.9387 11.2671 13.697C11.2903 13.2923 11.3415 12.8752 11.4205 12.645C11.5292 12.3286 11.689 12.0617 11.8999 11.8444C12.1141 11.6238 12.3793 11.4129 12.6957 11.2115C12.9322 11.0581 13.1304 10.8967 13.2902 10.7273C13.4532 10.5548 13.5762 10.3662 13.6593 10.1616C13.7456 9.95391 13.7888 9.72859 13.7888 9.48569C13.7888 9.14052 13.7073 8.83849 13.5443 8.57962C13.3845 8.32074 13.1672 8.12099 12.8923 7.98036C12.6174 7.83654 12.3122 7.76463 11.9766 7.76463C11.657 7.76463 11.3582 7.83494 11.0802 7.97557C10.8053 8.113 10.58 8.31754 10.4042 8.58921C10.2987 8.75332 10.2224 8.94133 10.1755 9.15322C10.1226 9.39161 9.92847 9.58636 9.6843 9.58636C9.42759 9.58636 9.21735 9.37282 9.2626 9.12013C9.32265 8.78477 9.43791 8.48315 9.60838 8.21527C9.85448 7.82855 10.1837 7.52972 10.596 7.31879C11.0082 7.10465 11.4685 6.99759 11.9766 6.99759C12.5072 6.99759 12.9738 7.10785 13.3765 7.32837C13.7792 7.5457 14.094 7.84453 14.3209 8.22486C14.5478 8.60199 14.6613 9.03505 14.6613 9.52404C14.6613 9.84684 14.6102 10.1409 14.5079 10.4061C14.4056 10.6714 14.2522 10.9159 14.0477 11.1396C13.8463 11.3634 13.5938 11.5743 13.2902 11.7724C13.0026 11.9642 12.774 12.1544 12.6047 12.3429C12.4353 12.5315 12.3138 12.7472 12.2403 12.9901C12.1929 13.1447 12.1594 13.4303 12.14 13.7079C12.1233 13.9452 11.9298 14.1359 11.6919 14.1359Z" fill="black"/>
                <path d="M11.713 17.0219C11.5244 17.0219 11.3614 16.9548 11.224 16.8206C11.0897 16.6831 11.0226 16.5201 11.0226 16.3316C11.0226 16.1398 11.0897 15.9768 11.224 15.8426C11.3614 15.7083 11.5244 15.6412 11.713 15.6412C11.9015 15.6412 12.0629 15.7083 12.1972 15.8426C12.3346 15.9768 12.4033 16.1398 12.4033 16.3316C12.4033 16.4562 12.3713 16.5713 12.3074 16.6767C12.2467 16.7822 12.1636 16.8669 12.0581 16.9308C11.9559 16.9916 11.8408 17.0219 11.713 17.0219Z" fill="black"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" fill="black"/>
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[30%]">Support</p>
            </template>
          </LeftSideMenu>

          <LeftSideMenu @click="showPopUp('logout')">
            <template v-slot:icon>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 3.99998C12 4.27613 11.7761 4.49998 11.5 4.49998H5C4.72386 4.49998 4.5 4.72384 4.5 4.99998V19C4.5 19.2761 4.72386 19.5 5 19.5H11.5C11.7761 19.5 12 19.7238 12 20C12 20.2761 11.7761 20.5 11.5 20.5H5C4.17157 20.5 3.5 19.8284 3.5 19V4.99998C3.5 4.17156 4.17157 3.49998 5 3.49998H11.5C11.7761 3.49998 12 3.72384 12 3.99998Z" fill="black"/>
                <path d="M15.0001 16.2929L18.7929 12.5001H8.50005C8.22391 12.5001 8.00005 12.2762 8.00005 12.0001C8.00005 11.7239 8.22391 11.5001 8.50005 11.5001H18.7929L15 7.70715C14.8048 7.51189 14.8048 7.19531 15 7.00005C15.1953 6.80478 15.5119 6.80478 15.7071 7.00005L20.3536 11.6465C20.4474 11.7403 20.5 11.8675 20.5 12.0001C20.5 12.1327 20.4474 12.2599 20.3536 12.3536L15.7072 17C15.5119 17.1953 15.1953 17.1953 15.0001 17C14.8048 16.8048 14.8048 16.4882 15.0001 16.2929Z" fill="black"/>
                </svg>
            </template>
            <template v-slot:menu>
              <p class="pt-1 w-[30%]">Logout</p>
            </template>
          </LeftSideMenu>

          


        <div class="h-4"></div>
        <div class="h-10 mt-2 mr-1 text-[14px] bg-transparent ring-4 ring-[#f3f3f3] rounded-lg  flex cursor-pointer">
          <!-- src="https://img.icons8.com/?size=512&id=108652&format=png" -->
          <img  :src="
          getUsers.profile_pic != undefined ? 
          (getUsers.profile_pic.includes('https://lh3.googleusercontent.com') == false
           ? urlPath+'/avatar/' +getUsers.profile_pic : getUsers.profile_pic)
           : 'https://img.icons8.com/?size=512&id=108652&format=png'" class="h-[40px] w-[40px] rounded-full">
          <span class="flex-none -space-y-2">
            <p class="font-bold pl-3 pt-1 flex-none">{{ getUsers.name }}</p>
            <p class="w-32 text-xs pl-3 pt-2 ">({{ getUsers.user_type }})</p>
          </span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-3 ml-20 w-4 h-4 text-grey">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
          </svg>
        </div>
        <div class="h-10"></div>
        
        </div>
      </div>
    </div>
</template>
<script>
import { useUserStore } from '../stores/auth'
import { uiChangesStore } from '../stores/ui_changes'

import { onMounted,ref,computed } from 'vue';
import { useRouter } from 'vue-router';
import LeftSideMenu from './left_side_menu.vue';

export default {
    name:"Sidebar",
    components:{
      LeftSideMenu,
   },
  setup() {
    const store = useUserStore();
    const uiStore = uiChangesStore();
    const currentUser = ref([]);
    const urlPath = window.location.origin;
    const router = useRouter();



    function logout(){
      if(store.logout())
      {
         localStorage.removeItem('token')
         window.location.href="/auth/login";
      }
    }

    const getUsers = computed(() => {
      currentUser.value = store.userDetails
      return currentUser.value;
    });

    let isMenuClicked = computed(() => uiStore.isMenuClicked);

    function showPopUp(popup_type,to=''){
      toggleSideBar()
      return uiStore.openPopUpFunc(popup_type,to);
    }

    function toggleSideBar(){
        isMenuClicked =! isMenuClicked
        return uiStore.isLeftMenuSelected(isMenuClicked)         
      }
    

    onMounted(() => {
      if(store.getUserData())
      {
        currentUser.value = store.userDetails
        currentUser.value.length == 0 && localStorage.getItem("token") == undefined  ? router.push({ path:"/auth/login"}):"";
      }
    });

    return {currentUser,urlPath,logout,getUsers,isMenuClicked,showPopUp,toggleSideBar}

  },
}
</script>