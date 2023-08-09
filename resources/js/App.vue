<template>
    <div  style="font-family: 'Rubik';">
      <header1 v-if="fullUrl.includes('dashboard') == false"  />
      <router-view></router-view>
    </div>
  </template>
  <script>
  import header1 from './components/header1.vue'
  export default {
    name: 'App',
    components:{
    header1
    },
    data: () => ({
        fullUrl:"",
      }),
      watch:{
    '$route' (){
      this.fullUrl = window.location.href;
      }
     },
  }
  </script>
  <style>
  @font-face {
    font-family: 'Rubik';
    src:  url("../../public/fonts/Rubik/Rubik-VariableFont_wght.ttf") format('truetype');
  }
</style>
