<template>
  <ion-menu content-id="main-content">
    <ion-header>
      <ion-toolbar>
        <img src="@/assets/bma.png" alt="BMA Logo" class="logo1" slot="start">
        <ion-title class="title" slot="start"><strong>E-QMS</strong></ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-list class="SideList">
      <!-- Show these items for admin role -->
      <template v-if="$route.path.startsWith('/dashboard') || $route.matched.some(record => record.path.startsWith('/dashboard'))">
        <ion-item router-link="/dashboard" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
        <ion-item router-link="/addPolicy" color="success" class="itemsK"><strong> Policy Documents</strong></ion-item>
        <ion-item router-link="/addProcedures" color="success" class="itemsK"><strong> Procedures </strong></ion-item>
        <ion-item router-link="/addWorkInstructions" color="success" class="itemsK"><strong> Work Instructions </strong></ion-item>
        <ion-item @click="toggleFormsDropdown" color="success">
          <strong> Forms </strong>
          <ion-icon slot="end" :icon="showGeneralForms ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showGeneralForms" class="subList">
          <ion-item router-link="/addForm" color="success" class="itemsK subItem"><strong> General Forms </strong></ion-item>
          <ion-item router-link="/addDepartments" color="success" class="itemsK subItem"><strong> Department Forms </strong></ion-item>
        </ion-list>
        <ion-item router-link="/addRecords" color="success" class="itemsK"><strong> Records </strong></ion-item>
      </template>
      <!-- Show these items for user role -->
      <template v-else-if="$route.path.startsWith('/userdashboard') || $route.matched.some(record => record.path.startsWith('/userdashboard'))">
        <ion-item router-link="/userdashboard" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
        <ion-item @click="toggleFormsDropdown" color="success">
          <strong> Forms </strong>
          <ion-icon slot="end" :icon="showGeneralForms ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showGeneralForms" class="subList">
          <ion-item router-link="/generalForms" color="success" class="itemsK subItem"><strong> General Forms </strong></ion-item>
          <ion-item router-link="/departmentForms" color="success" class="itemsK subItem"><strong> Department Forms </strong></ion-item>
        </ion-list>
        <!-- Add other sidebar items for userdashboard here -->
      </template>
    </ion-list>
    <ion-button @click="logout" shape="round" class="btn logout" color="success"><strong>Logout</strong></ion-button>
  </ion-menu>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-buttons slot="start">
          <ion-menu-button></ion-menu-button>
        </ion-buttons>
        <img src="@/assets/bma.png" alt="BMA Logo" class="logo2" slot="start">
        <ion-title slot="start">
          <strong>BALIWAG MARITIME ACADEMY</strong>
        </ion-title>
        <ion-searchbar class="search"></ion-searchbar>
        <!-- Change title based on the route -->
        <ion-title slot="end"><strong>{{ $route.path.startsWith('/userdashboard') ? 'User' : 'Admin' }}</strong></ion-title>
        <img src="@/assets/marine.png" alt="BMA Logo" class="logo3" slot="end" shape="round">
      </ion-toolbar>
    </ion-header>
    <ion-router-outlet id="main-content"></ion-router-outlet>
  </ion-page>
</template>

<script>
import { IonMenu, IonHeader, IonToolbar, IonTitle, IonButton, IonList, IonItem, IonRouterOutlet, IonPage, IonButtons, IonMenuButton, IonIcon } from '@ionic/vue';
import { defineComponent, ref } from 'vue';
import { useRouter } from 'vue-router'; 
import { chevronDown, chevronUp } from 'ionicons/icons';

export default defineComponent({
  setup() {
    const router = useRouter();
    const logout = () => {
      router.push({ name: 'Login' });
    };

    const showGeneralForms = ref(false);

    const toggleFormsDropdown = () => {
      showGeneralForms.value = !showGeneralForms.value;
    };

    return {
      logout,
      showGeneralForms,
      toggleFormsDropdown
    };
  },
  components: {
    IonMenu,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonButton,
    IonList,
    IonItem,
    IonRouterOutlet,
    IonPage,
    IonButtons,
    IonMenuButton,
    IonIcon
  },
  data() {
    return {
      chevronDown,
      chevronUp
    };
  }
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

.subItem {
  font-size: 0.9em; 
}

.subList {
  width: 100%;
  margin-left: 20px;
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
