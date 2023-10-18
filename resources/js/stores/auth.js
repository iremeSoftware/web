import { defineStore } from 'pinia'
import axios from "../plugins/axios"

export const useUserStore = defineStore("auth", {
    state: () => ({
        userDetails: [],
        demoSchoolInfo:[],
        successMessage:"",
        errorMessage : "",
        confirmAccountErrorMessage : "",
        device_id : "",
        loadingUI :{
          isLoading:false
        },
        isGoogleUIDUpdated : false,
        isLoggingWithGoogle : false

    }),
    getters: {
      getUserDetails(state){
        return state.userDetails
      }
    },
    actions: {
        async login(credentials) {  
          let self = this;
          
            self.loadingUI.isLoading = true;
            self.errorMessage = "";
            await axios.post("login", credentials).then(function (response) {
                self.loadingUI.isLoading = false;
                const token = `Bearer ${response.data.access_token}`;
                localStorage.setItem("token", token);
                localStorage.setItem("d_id", credentials.d_id);
                self.device_id = credentials.d_id;
                self.userDetails.push(response.data.user);
                console.log(self.userDetails)
                axios.defaults.headers.common["Authorization"] = token;
            }).catch (function (err) {
              self.loadingUI.isLoading = false;
              self.userDetails = [];
              self.errorMessage = err.response.data;
            })
          },

            async getUserData() {
              this.userDetails = [];
              this.errorMessage = "";
              this.successMessage = "";
              
              const response = (await axios.post("current_user",{})).data;
              if (response) {
                this.userDetails= response.user_info;
              }
            },

            async updateGoogleUid(data) {
              let self = this;
              self.errorMessage = "";
              await axios.post('login/updateUid',data).then(function (response) {
                self.isGoogleUIDUpdated = response.data.status == 'UPDATED' ? true : false;
                console.log(response)
              }).catch(function(err){
                self.isGoogleUIDUpdated = false;
                console.log(err)
              })
            },

          async account_verification(account_id,verification_code) {
            let self = this;
            self.errorMessage = "";
            console.log(config)
            await axios.get(`verification/${account_id}/${verification_code}`,{}).then(function (response) {
              if(response.data.verified == 1)
              {
                localStorage.setItem("d_id",verification_code);
                self.device_id = verification_code;
                self.successMessage = response.data;
              }
            }).catch(function(err){
              self.userDetails = [];
              self.errorMessage = err.response.data;
            })
          },

          async forgot_password(email) {
            let self = this;
            self.errorMessage = "";
            self.loadingUI.isLoading = true;
            await axios.post('forgot_password',email).then(function (response) {
              self.loadingUI.isLoading = false;
              self.successMessage = response.data.status;
            }).catch(function(err){
              self.userDetails = [];
              self.loadingUI.isLoading = false;
              self.errorMessage = err.response.data.email[0];
            })
          },

          async reset_password(records) {
            let self = this;
            self.errorMessage = "";
            self.loadingUI.isLoading = true;
            await axios.post('reset_password',records).then(function (response) {
              self.loadingUI.isLoading = false;
              self.successMessage = response.data.status;
            }).catch(function(err){
              self.userDetails = [];
              self.loadingUI.isLoading = false;
              self.errorMessage = err.response.data;
            })
          },

          async registration_request(data) {
            let self = this;
            self.errorMessage = "";
            self.loadingUI.isLoading = true;
            await axios.post('registration/request/send',data).then(function (response) {
              self.loadingUI.isLoading = false;
              self.successMessage = response.data.message;
            }).catch(function(err){
              self.userDetails = [];
              self.loadingUI.isLoading = false;
              self.errorMessage = err.response.data;
            })
          },

          async get_registration_request_info(token) {
            let self = this;
            self.errorMessage = "";
            self.loadingUI.isLoading = true;
            await axios.get(`registration/request/${token}`,{}).then(function (response) {
              self.loadingUI.isLoading = false;
              self.demoSchoolInfo = response.data;
            }).catch(function(err){
              self.demoSchoolInfo = [];
              self.loadingUI.isLoading = false;
              self.errorMessage = err.response.data;
            })
          },


          async confirm_account(token) {
            let self = this;
            self.confirmAccountErrorMessage = "";
            //self.loadingUI.isLoading = true;
            await axios.get(`confirm_account/${token}`,{}).then(function (response) {
              //self.loadingUI.isLoading = false;
              self.successMessage  = response.data.status;
            }).catch(function(err){
              //self.loadingUI.isLoading = false;
              self.confirmAccountErrorMessage = err.response.data.status;
            })
          },
      
      
          async complete_registration(data) {
            let self = this;
            self.errorMessage = "";
            self.loadingUI.isLoading = true;
            await axios.post('register',data).then(function (response) {
              self.loadingUI.isLoading = false;
              self.successMessage = response.data.status;
            }).catch(function(err){
              self.userDetails = [];
              self.loadingUI.isLoading = false;
              self.errorMessage = err.response.data;
            })
          },
      
          async logout() {
            let self = this;
            self.errorMessage = "";
            await axios.post("logout",{}).then(function (response) {
              self.userDetails = [];
              localStorage.removeItem("token");
            }).catch(function(err){
              self.userDetails = [];
              self.errorMessage = err.response.data;
            })
          },
    },
})