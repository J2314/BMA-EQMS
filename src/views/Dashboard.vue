<template>
  <ion-content>
    <div class="additional-buttons">
      <ion-button router-link="/dashboard"><strong>Statistics</strong></ion-button>
      <ion-button router-link="/dashboard"><strong>Announcements</strong></ion-button>
      <ion-button router-link="/dashboard"><strong>Monitoring</strong></ion-button>
      <ion-button router-link="/dashboard"><strong>Calendar</strong></ion-button>
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
