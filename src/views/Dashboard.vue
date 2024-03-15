<template>
  <ion-content class="ion-padding"> Dashboard </ion-content>
</template>

<script>
import { IonButtons, IonContent, IonHeader, IonMenu, IonMenuButton, IonPage, IonTitle, IonToolbar, IonItem } from '@ionic/vue';
import { defineComponent } from 'vue';

export default defineComponent({
  components: {
    IonButtons,
    IonContent,
    IonHeader,
    IonMenu,
    IonMenuButton,
    IonPage,
    IonTitle,
    IonToolbar,
    IonItem
  },
});
</script>

<style scoped>
.title {
  text-align: center;
}

.SideList {
  flex: 1;
  margin-right: 12px;
  margin-left: 10px;
}

.itemsK {
  margin-bottom: 5px;
}

.logout {
  margin-right: 12px;
  margin-left: 10px;
  margin-bottom: 10px;
}

.logo1 {
  width: 50px;
  height: 50px;
  margin: 5px;
  margin-left: 50px;
  margin-right: -20px;
}

.logo2 {
  width: 50px;
  height: 50px;
  margin: 5px;
  margin-right: -10px;
}

.logo3 {
  width: 50px;
  height: 50px;
  margin-right: 15px;
}
</style>
