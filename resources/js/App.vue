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

  @font-face {
    font-family: 'Vardena';
    src:  url("../../public/fonts/vardena-cufonfonts/VardenaPersonalUsed-z8vnw.ttf") format('truetype');
  }

  @font-face {
    font-family: 'First_Love';
    src:  url("../../public/fonts/first-love/First_Love.otf") format('truetype');
  }
  @font-face {
    font-family: 'Morison_Serif_Font';
    src:  url("../../public/fonts/morison/Fonts/morison-displaylight.otf") format('truetype');
  }
  @font-face {
    font-family: 'Antique_Gothic_Sans_Serif_Font';
    src:  url("../../public/fonts/antique-gothic-font-1703121062-0/antiquegothic-light-trial.otf") format('truetype');
  }
</style>
