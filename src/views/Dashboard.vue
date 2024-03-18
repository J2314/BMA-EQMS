<template>
  <ion-content>
    <div class="additional-buttons">
      <ion-button @click="navigateTo('statistics')">Statistics</ion-button>
      <ion-button @click="navigateTo('announcements')">Announcements</ion-button>
      <ion-button @click="navigateTo('monitoring')">Monitoring</ion-button>
      <ion-button @click="navigateTo('calendar')">Calendar</ion-button>
    </div>
    <TheStats />
  </ion-content>
</template>

<script>
import { IonContent, IonButton } from '@ionic/vue';
import TheStats from '@/components/TheStats.vue'; 

export default {
  components: {
    IonContent,
    IonButton,
    TheStats,
  },
  methods: {
    navigateTo(route) {
      console.log(`Navigating to ${route}`);
    }
  }
};
</script>

<style scoped>
.additional-buttons {
  display: flex;
  justify-content: center;
  margin-top: 7%;
}
</style>
