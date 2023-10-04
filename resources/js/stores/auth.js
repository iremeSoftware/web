import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "../plugins/axios"


export const useUserStore = defineStore("auth", {
    state: () => ({
        userDetails: [],
        successMessage:"",
        errorMessage : "",
        device_id : "",
        loadingUI :{
          isLoading:false
        },

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
                axios.defaults.headers.common["Authorization"] = token;
            }).catch (function (err) {
              self.loadingUI.isLoading = false;
              self.userDetails = [];
              self.errorMessage = err.response.data;
            })
          },
          async getUserData() {
            let token = localStorage.getItem("token")
            let config = { 
              headers: {
                "Authorization": token,
              }
            }
            this.userDetails = [];
            this.errorMessage = "";
            this.successMessage = "";
            
            const response = (await axios.post("current_user",{},config)).data;
            if (response) {
              this.userDetails= response.user_info;
            }
          },

          async account_verification(account_id,verification_code) {
            let token = localStorage.getItem("token")
            let config = { 
              headers: {
                "Authorization": token,
              }
            }
            let self = this;
            self.errorMessage = "";
            console.log(config)
            await axios.get(`verification/${account_id}/${verification_code}`,{},config).then(function (response) {
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
      
          async logout() {
            let token = localStorage.getItem("token")
            let config = { 
              headers: {
                "Authorization": token,
              }
            }
            let self = this;
            self.errorMessage = "";
            await axios.post("logout",{},config).then(function (response) {
              self.userDetails = [];
              localStorage.removeItem("token");
            }).catch(function(err){
              self.userDetails = [];
              self.errorMessage = err.response.data;
            })
          },
    },
})