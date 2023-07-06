<template>
    <div  style="font-family: 'Rubik';">
      <header1 />
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
    setup() {
  
     }
  }
  </script>
  <style>
  @font-face {
    font-family: 'Rubik';
    src:  url("../../public/fonts/Rubik/Rubik-VariableFont_wght.ttf") format('truetype');
  }
</style>
