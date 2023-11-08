import login from '../pages/auth/login.vue'
import resetPassword from '../pages/auth/reset_password.vue'
import changePassword from '../pages/auth/change_password.vue'
import home from '../pages/home.vue'
import registrationRequest from '../pages/auth/register_request.vue'
import pay from '../pages/pay.vue'
import verification_code from '../pages/auth/verification_code.vue'
import dashboard from '../pages/dashboard/dashboard.vue'
import registerSchool from '../pages/auth/register_school.vue'
import studentsPage from '../pages/dashboard/students_list.vue'
import AssignCourses from '../pages/dashboard/assign_courses.vue'
import coursesList from '../pages/dashboard/course_list.vue'
import classroomsList from '../pages/dashboard/classrooms_list.vue'


const routes = [
  {
    path: '/',
    name: 'home',
    component: home
  },
  {
    path: '/auth',
    children: [
      {
        path: 'login',
        name: 'login',
        component: login
      },
      {
        path: 'resetPassword',
        name: 'reset_password',
        component: resetPassword
      },
      {
        path: 'password/reset/:token',
        name: 'ChangePassword',
        component: changePassword
      },
      {
        path: 'registration_request',
        name:'registrationRequest',
        component:registrationRequest
      },

      {
        path: 'verification_code/:account_id',
        name:'verification_code',
        component:verification_code
      },
      {
        path: 'register_school/:token',
        name:'registerSchool',
        component:registerSchool
      }
    ],
  },
  {
    path: '/dashboard',
    children: [
      {
        path: 'home',
        component: dashboard,
      },
      {
        path: 'students/:class_id',
        component: studentsPage,
      },
      {
        path: 'courses/assign',
        component: AssignCourses,
      },
      {
        path: 'courses/list',
        component: coursesList,
      },
      {
        path: 'classrooms/list',
        component: classroomsList,
      },
    ],

  }
 
]

export default routes