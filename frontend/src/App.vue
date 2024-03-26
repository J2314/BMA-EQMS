<template>
  <ion-app>
    <main-layout></main-layout>
  </ion-app>
</template>

<script>
import MainLayout from '@/views/MainLayout.vue'
import { IonApp, IonRouterOutlet } from '@ionic/vue';
export default {
  components:{
    MainLayout
  }
}
</script>
