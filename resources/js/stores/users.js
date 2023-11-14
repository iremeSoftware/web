import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const manageUserStore = defineStore("users", {
    state: () => ({
        usersList: [],
        userTrackerDetails : {},
        userRolesList:[],
        isUserInactive:"",
        successMessageArr:"",
        successMessage:"",
        errorMessage : "",
        loadingUI :{
          isLoading:false
        },
        schools_list:[]
    }),
    getters: {
      getStaffUsers(state){
        return state.userDetails
      }
    },
    actions: {
        async createNewUser(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('users',data).then(function (response) {
              self.loadingUI.isLoading = false
              self.successMessage = response.data.status
              self.usersList = response.data.data
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async updateUserData(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('account/settings',data).then(function (response) {
              self.successMessage = response.data.message
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async changeUserPassword(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post('account/change_password',data).then(function (response) {
              self.successMessage = response.data.status;
            }).catch(function(err){
              self.errorMessage = err.response.data.errors
              self.loadingUI.isLoading = false
            })
          },
          async trackUser() {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.get('user/tracker').then(function (response) {
              self.userTrackerDetails = response.data.UserTrackers;
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async createUserTracker(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post('user/tracker',data).then(function (response) {
              self.successMessage = response.data.message;
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async checkInactiveUser(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.post('user/tracker/active',data).then(function (response) {
              self.isUserInactive = response.data.message.inactive;
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getSchoolUsers(school_id) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = false
            await axios.get(`users/${school_id}`).then(function (response) {
              self.usersList = response.data.users;
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async importUsersCSV(data,frmData) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            
            await axios({
              method: "POST",
              url: `users/${data.school_id}/importcsv`,
              data: frmData,
              headers: {
                  "Content-Type": "multipart/form-data",
              },
          }).then(function (response) {
              self.successMessageArr = response.data
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response
              self.loadingUI.isLoading = false
            })
          },
          async getUsersRole(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            data.school_id = 
            await axios.get(`user_roles/${data.school_id}?limit=${data.limit}&page=${data.page}`).then(function (response) {
              self.userRolesList = response.data.user_roles;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async createUsersRole(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post('user_roles',data).then(function (response) {
              self.userRolesList = response.data.status;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data.exist
              self.loadingUI.isLoading = false
            })
          },
          async getUserUserRole(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`user_roles/${data.school_id}/${data.account_id}/${data.user_role}?limit=${data.limit}&page=${data.page}`).then(function (response) {
              self.userRolesList = response.data.user_roles;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async getUsersAuthentications(data="") {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            let school_id = localStorage.getItem("school_id") ?? ''
            await axios.get(`authentication/${school_id}?records=all&limit=${data.limit}&page=${data.page}&sort=${data.sort}&sort_by=${data.sort_by}`).then(function (response) {
              self.usersList = response.data;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async getAllAuthentications(account_id) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.get(`authentication/null?account_id=${account_id}`).then(function (response) {
              self.schools_list = response.data.authentication;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async searchUsersAuthentications(data="") {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            let school_id = localStorage.getItem("school_id") ?? ''
            await axios.post(`authentication/search/${school_id}`,data).then(function (response) {
              self.usersList = response.data;
              self.loadingUI.isLoading = false
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          async updateUsersAuthentications(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            let school_id = localStorage.getItem("school_id") ?? ''
            await axios.post(`authentication/update/${school_id}`,data).then(function (response) {
              self.successMessage = response.data.message;
              self.loadingUI.isLoading = false
              self.getUsersAuthentications()
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },

          async deleteSchoolUser(data) {  
            let self = this
            self.errorMessage = ""
            self.loadingUI.isLoading = true
            await axios.post(`delete/user`,data).then(function (response) {
              self.successMessage = response.data.message;
              self.loadingUI.isLoading = false
              self.getUsersAuthentications()
            }).catch(function(err){
              self.errorMessage = err.response.data
              self.loadingUI.isLoading = false
            })
          },
          
    },
})