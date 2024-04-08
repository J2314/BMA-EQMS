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

<!-- php artisan serve --port 7070 --host 192.168.100.8
npm run dev -- --port 8080 --host 192.168.100.8 -->