<template>
  <ion-menu content-id="main-content">
    <ion-header>
      <ion-toolbar>
        <ion-title class="title">E-QMS</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-list class="SideList">
      <ion-item router-link="/your-route"><strong> Dashboard </strong></ion-item>
      <ion-item router-link="/your-route"><strong> Forms </strong></ion-item>
      <ion-item router-link="/your-route"><strong> Departments </strong></ion-item>
      <ion-item router-link="/your-route"><strong> Reports </strong></ion-item>
      <ion-item router-link="/your-route"><strong> Etc.. </strong></ion-item>
    </ion-list>
    <ion-button shape="round">Logout</ion-button>
  </ion-menu>
  <ion-page id="main-content">
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="start">
          <ion-menu-button></ion-menu-button>
        </ion-buttons>
        <ion-title>Menu</ion-title>
        <ion-searchbar slot="end" class="search"></ion-searchbar>
      </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding"> Tap the button in the toolbar to open the menu. </ion-content>
  </ion-page>
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
.search {
  flex: 1;
  max-width: 400px;
  margin-right: 300px;
}

.title {
  text-align: center;
}

.SideList {
  flex:1;
  margin-right: 15px;
}
</style>
