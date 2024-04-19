<script>
import { IonMenu, IonHeader, IonToolbar, IonTitle, IonButton, IonList, IonItem, IonRouterOutlet, IonPage, IonButtons, IonMenuButton, IonIcon, IonSearchbar } from '@ionic/vue';
import { defineComponent } from 'vue';
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
    },
    ...mapGetters('auth', {
        isAuthenticated: IS_USER_AUTHENTICATE_GETTER,
    }),
    activeItem() {
      const trimmedPath = this.$route.path.replace(/\/$/, ''); // Trim the route path to remove any trailing slashes
      return trimmedPath; // Use the trimmed path of the current route
    }
  },
  methods: {
    ...mapActions('auth', {
      logout: LOGOUT_ACTION,
    }),
    onLogout() {
      this.logout();
      this.$router.push('/login');
    },
    reloadPage(path) {
      this.$router.push(path).then(() => {
        window.location.reload();
      });
    },
    toggleUserFormsDropdown() {
      this.showUserForms = !this.showUserForms; // Toggle the visibility of the user forms dropdown
    },
    toggleUserPolicyDropdown() {
      this.showUserPolicy = !this.showUserPolicy; // Toggle the visibility of the user policy dropdown
    },
    toggleAdminSettingsDropdown() {
      this.showAdminSettings = !this.showAdminSettings; // Toggle the visibility of the admin settings dropdown
    }
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
    IonIcon,
    IonSearchbar
  },
  data() {
    return {
      chevronDown,
      chevronUp,
      showUserForms: false, // Initially hide the user forms dropdown
      showUserPolicy: false, // Initially hide the user policy dropdown
      showAdminSettings: false // Initially hide the admin settings dropdown
    };
  }
});
</script>

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
        <ion-item @click="reloadPage('/admin/dashboard')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/dashboard' }"> Dashboard </ion-item>
        <ion-item @click="reloadPage('/admin/addPolicy')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addPolicy' }"> Policy Documents</ion-item>
        <ion-item @click="reloadPage('/admin/addProcedures')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addProcedures' }"> Procedures </ion-item>
        <ion-item @click="reloadPage('/admin/addWorkInstructions')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addWorkInstructions' }"> Work Instructions </ion-item>
        <ion-item @click="reloadPage('/admin/addDepartments')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addDepartments' }"> Departments </ion-item>
        <ion-item @click="reloadPage('/admin/addForm')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addForm' }"> Forms </ion-item>
        <ion-item @click="reloadPage('/admin/addRecords')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/addRecords' }"> Records </ion-item>
        <ion-item @click="toggleAdminSettingsDropdown" class="menu-item" :class="{ 'active-item': activeItem === '/admin/settings' }">
          Settings
          <ion-icon slot="end" :icon="showAdminSettings ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showAdminSettings" class="subList">
          <ion-item @click="reloadPage('/admin/accountManagement')" class="menu-item" :class="{ 'active-item': activeItem === '/admin/accountManagement' }">Account Management</ion-item>
          <!-- Add other settings items here -->
        </ion-list>
      </template>
      <!-- Show these items for user role -->
      <template v-if="$route.path.startsWith('/user/')">
        <ion-item @click="reloadPage('/user/dashboard')" class="menu-item" :class="{ 'active-item': activeItem === '/user/dashboard' }"> Dashboard </ion-item>
        <ion-item @click="toggleUserPolicyDropdown" class="menu-item" :class="{ 'active-item': activeItem === '/user/policy' }">
          Policy Documents
          <ion-icon slot="end" :icon="showUserPolicy ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showUserPolicy" class="subList">
          <ion-item @click="reloadPage('/user/generalPolicy')" class="menu-item" :class="{ 'active-item': activeItem === '/user/generalPolicy' }">General Policy</ion-item>
          <ion-item @click="reloadPage('/user/departmentPolicy')" class="menu-item" :class="{ 'active-item': activeItem === '/user/departmentPolicy' }">Department Policy </ion-item>
        </ion-list>
        <ion-item @click="toggleUserFormsDropdown" class="menu-item" :class="{ 'active-item': activeItem === '/user/forms' }">
          Forms
          <ion-icon slot="end" :icon="showUserForms ? chevronUp : chevronDown"></ion-icon>
        </ion-item>
        <ion-list v-show="showUserForms" class="subList">
          <ion-item @click="reloadPage('/user/generalForms')" class="menu-item" :class="{ 'active-item': activeItem === '/user/generalForms' }">General Forms</ion-item>
          <ion-item @click="reloadPage('/user/departmentForms')" class="menu-item" :class="{ 'active-item': activeItem === '/user/departmentForms' }">Department Forms </ion-item>
        </ion-list>
        <!-- Add other user items similarly -->
      </template>
    </ion-list>
    <ion-button @click="onLogout()" shape="round" class="btn logout" color="success" ><strong>Logout</strong></ion-button> 
    <!-- v-if="isAuthenticated for logout -->
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
        <ion-title slot="end"><strong>{{ $route.path.startsWith('/user/')  ? 'User' : 'Admin' }}</strong></ion-title>
        <img src="@/assets/marine.png" alt="BMA Logo" class="logo3" slot="end" shape="round">
      </ion-toolbar>
    </ion-header>
    <ion-router-outlet id="main-content"></ion-router-outlet>
  </ion-page>
</template>

<style scoped>
.title {
  text-align: center;
}

.SideList {
  flex: 1;
  margin-right: 12px;
  margin-left: 10px;
}

.menu-item {
  transition: all 0.3s ease-in-out;
  color: black;
}

.menu-item:hover,
.menu-item.active-item {
  font-weight: bold;
  --background: #4caf50; /* Set the background color to green */
  color: white; 
}

.logout {
  margin-right: 12px;
  margin-left: 10px;
  margin-bottom: 10px;
}

.subList {
  width: 100%;
  margin-left: 20px;
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
