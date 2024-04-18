<template>
  <ion-content>
    <div class="additional-buttons">
      <ion-button router-link="/admin/statistics"><strong>Statistics</strong></ion-button>
      <ion-button router-link="/admin/announcements"><strong>Announcements</strong></ion-button>
      <ion-button router-link="/admin/monitoring"><strong>Monitoring</strong></ion-button>
      <ion-button router-link="/admin/calendar"><strong>Calendar</strong></ion-button>
    </div>
    <TheStats />
  </ion-content>
  <router-view></router-view>
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
