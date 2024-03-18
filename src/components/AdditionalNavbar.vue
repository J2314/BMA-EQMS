<template>
  <ion-content>
    <div class="additional-navbar">
      <ion-button @click="navigateTo('statistics')" class="navbar-link">Statistics</ion-button>
      <ion-button @click="navigateTo('announcements')" class="navbar-link">Announcements</ion-button>
      <ion-button @click="navigateTo('monitoring')" class="navbar-link">Monitoring</ion-button>
      <ion-button @click="navigateTo('calendar')" class="navbar-link">Calendar</ion-button>
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
    },
  },
};
</script>

<style scoped>
.additional-navbar {
  background-color: #087f23;
  padding: 25px;
  margin-top: 6%;
  margin-right: 15%;
  margin-left: 20%;
  border-radius: 20px;
}

.navbar-link {
  color: #fff !important; /* Use !important to ensure styles are applied */
  text-decoration: none;
  font-size: 22px;
  transition: font-weight 0.3s;
  display: block;
  text-align: center;
  position: relative;
  font-weight: normal;
}

.navbar-link:hover {
  font-weight: bold;
}

.navbar-link::after {
  content: '';
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  bottom: -5px;
  width: 50%;
  height: 4px;
  background-color: transparent;
  transition: background-color 0.3s, width 0.3s, height 0.3s;
}

.navbar-link:hover::after {
  background-color: #ffd700;
  width: 70%;
  height: 6px;
}
</style>
