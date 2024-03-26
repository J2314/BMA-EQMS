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
      <template v-if="$route.path.startsWith('/admin/')">
        <ion-item router-link="/admin/dashboard" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
        <ion-item router-link="/admin/addPolicy" color="success" class="itemsK"><strong> Policy Documents</strong></ion-item>
        <ion-item router-link="/admin/addProcedures" color="success" class="itemsK"><strong> Procedures </strong></ion-item>
        <ion-item router-link="/admin/addWorkInstructions" color="success" class="itemsK"><strong> Work Instructions </strong></ion-item>
        <ion-item router-link="/admin/addForm" color="success" class="itemsK"><strong> Forms </strong></ion-item>
        <ion-item router-link="/admin/addRecords" color="success" class="itemsK"><strong> Records </strong></ion-item>
      </template>
      <!-- Show these items for user role -->
      <template v-if="$route.path.startsWith('/userdashboard')">
        <ion-item router-link="/userdashboard" color="success" class="itemsK"><strong> Dashboard </strong></ion-item>
        <ion-item router-link="/userdashboard/policy" color="success" class="itemsK"><strong> Policy Documents</strong></ion-item>
        <ion-item @click="toggleUserFormsDropdown" color="success">
          <strong> Forms </strong>
          <ion-icon slot="end" :icon="showUserForms ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showUserForms" class="subList">
          <ion-item router-link="/userdashboard/generalForms" color="success" class="itemsK subItem"><strong> General Forms </strong></ion-item>
          <ion-item router-link="/userdashboard/departmentForms" color="success" class="itemsK subItem"><strong> Department Forms </strong></ion-item>
        </ion-list>
      </template>
    </ion-list>
    <ion-button @click="onLogout()" shape="round" class="btn logout" color="success" v-if="isAuthenticated"><strong>Logout</strong></ion-button>
  </ion-menu>
  <ion-page>
    <ion-header v-if="showNavigation">
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
        <ion-title slot="end"><strong>{{ $route.path.startsWith('/userdashboard') ||
        $route.path.startsWith('/generalForms') || $route.path.startsWith('/departmentForms') ||
        $route.path.startsWith('/policy') ? 'User' : 'Admin' }}</strong></ion-title>

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
import { mapActions, mapGetters } from 'vuex';
import {
    IS_USER_AUTHENTICATE_GETTER,
    LOGOUT_ACTION,
} from '../store/storeconstants';

export default defineComponent({
  computed: {
    showNavigation() {
    return !['/login', '/signup'].includes(this.$route.path);
  }
},
  setup() {
    const router = useRouter();
    const logout = () => {
      router.push({ name: 'Login' });
    };

    const showUserForms = ref(false);

    const toggleUserFormsDropdown = () => {
      showUserForms.value = !showUserForms.value;
    };

    const reloadPage = (path) => {
      router.push(path).then(() => {
        window.location.reload();
      });
    };

    return {
      logout,
      showUserForms,
      toggleUserFormsDropdown,
      reloadPage
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
