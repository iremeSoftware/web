import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const studentsMarksStore = defineStore("students_marks", {
    state: () => ({
        studentsMarks: [],
        studentsSorts: [],
        maximumPoints:{},
        successMessage:"",
        successMessageArr:[],
        errorMessage : "",
        quiz_maximum:localStorage.getItem('quiz_maximum') ?? 0,
        loadingUI :{
          isLoading:false
        },
    }),
    getters: {
   
    },
    actions: {
        async getStudentMarks(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.get(`marks/${data.school_id}/${data.class_id}/${data.course_id}/${data.student_id}?page=${data.page}&limit=${data.limit}&sort=${data.sort}&sort_by=${data.sort_by}`,{}).then(function (response) {
              self.studentsMarks = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsMarks = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getStudentMarksAssessment(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.get(`assessment/${data.school_id}/${data.class_id}?page=${data.page}&limit=${data.limit}&sort=${data.sort}&sort_by=${data.sort_by}`,{}).then(function (response) {
              self.studentsMarks = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsMarks = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getStudentsAverageMarks(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post(`marks/average`,data).then(function (response) {
              self.studentsMarks = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsMarks = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getStudentsSorts(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.get(`report_form/${data.school_id}/${data.class_id}?page=${data.page}&limit=${data.limit}&sort=${data.sort}&sort_by=${data.sort_by}`).then(function (response) {
              self.studentsSorts = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsSorts = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async searchStudentsSorts(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.get(`report_form_search/${data.school_id}/${data.class_id}?student_name=${data.student_name}&page=${data.page}&limit=${data.limit}&sort=${data.sort}&sort_by=${data.sort_by}`).then(function (response) {
              self.studentsSorts = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.studentsSorts = []
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async importStudentMarks(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post('marks',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async updateStudentMarks(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post('marks/update',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
              self.getStudentMarks(data)
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async searchStudentMarks(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post('marks/search',data).then(function (response) {
              self.studentsMarks = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getMaximumPoints(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.get(`out_of_marks/${data.school_id}/${data.class_id}/${data.course_id}`).then(function (response) {
              self.maximumPoints = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async updateMaximumPoints(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post(`out_of_marks`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async convertMaximumPoints(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = localStorage.getItem('school_id') ?? ""
            await axios.post(`out_of_marks/convert`,data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
         
    },
})