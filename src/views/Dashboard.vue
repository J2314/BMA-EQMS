<template>
  <ion-menu content-id="main-content">
    <ion-header>
      <ion-toolbar>
        <img src="@/assets/bma.png" alt="BMA Logo" class="logo1" slot="start">
        <ion-title class="title" slot="start"><strong>E-QMS</strong></ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-list class="SideList">
      <ion-item router-link="/dashboard" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Policy Documents </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Procedures </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Work Instructions </strong></ion-item>
      <ion-item router-link="/dashboard/addForm" color="success" class="itemsK"><strong> Forms </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Departments </strong></ion-item>
      <ion-item router-link="/your-route" color="success" class="itemsK"><strong> Records </strong></ion-item>
    </ion-list>
    <ion-button shape="round" class="btn logout" color="success"><strong>Logout</strong></ion-button>
  </ion-menu>
  <ion-page id="main-content">
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="start">
          <ion-menu-button></ion-menu-button>
        </ion-buttons>
        <img src="@/assets/bma.png" alt="BMA Logo" class="logo2" slot="start">
        <ion-title slot="start">
          <strong>BALIWAG MARITIME ACADEMY</strong>
        </ion-title>
        <ion-searchbar class="search" ></ion-searchbar>
        <ion-title slot="end"><strong>Admin</strong></ion-title>
        <img src="@/assets/marine.png" alt="BMA Logo" class="logo3" slot="end" shape="round">
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
  margin-right: 12px;
  margin-left: 10px;
}

.itemsK{
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
  margin:5px;
  margin-right: -10px;
}

.logo3 {
  width: 50px;
  height: 50px;
  margin-right: 15px;
}

</style>
