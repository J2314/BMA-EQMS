<template>
  <ion-menu content-id="main-content">
    <ion-header>
      <ion-toolbar>
        <ion-title class="title"><strong>E-QMS</strong></ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-list class="SideList">
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Forms </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Departments </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Reports </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Damn </strong></ion-item>
    </ion-list>
    <ion-button shape="round" class="btn logout" color="success"><strong>Logout</strong></ion-button>
  </ion-menu>
  <ion-page id="main-content">
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="start">
          <ion-menu-button></ion-menu-button>
        </ion-buttons>
        <ion-title slot="start"><strong>BALIWAG MARTIME ACADEMY</strong></ion-title>
        <ion-searchbar class="search"></ion-searchbar>
        <ion-title slot="end"><strong>Admin</strong></ion-title>
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

.title {
  text-align: center;
}

.SideList {
  flex:1;
  margin-right: 15px;
  margin-left: 10px;
}

.itemsK{
  margin-bottom: 5px;
}

.logout {
  margin-right: 15px;
  margin-left: 10px;
  margin-bottom: 10px;
}

</style>
