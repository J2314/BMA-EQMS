<template>
  <div>
    <nav class="additional-navbar" v-if="!removeAddNav">
      <div class="container">
        <div class="row">
          <div class="col">
            <router-link to="/dashboard/statistics" class="navbar-link">Statistics</router-link>
          </div>
          <div class="col">
            <router-link to="/dashboard/announcements" class="navbar-link">Announcements</router-link>
          </div>
          <div class="col">
            <router-link to="/dashboard/monitoring" class="navbar-link">Monitoring</router-link>
          </div>
          <div class="col">
            <router-link to="/dashboard/calendar" class="navbar-link">Calendar</router-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  computed: {
    removeAddNav() {
      return (
        this.$route.name === 'addForm' ||
        this.$route.name === 'addDepartment' ||
        this.$route.name === 'uploadForm' ||
        this.$route.name === 'addPolicy' ||
        this.$route.name === 'addProcedures'
      );
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
  color: #fff;
  text-decoration: none;
  font-size: 22px;
  transition: color 0.3s;
  display: block;
  text-align: center;
  position: relative;
  font-weight: normal;
}

.navbar-link:hover,
.navbar-link:focus {
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

.navbar-link:hover::after,
.navbar-link:focus::after {
  background-color: #ffd700;
  width: 70%;
  height: 6px;
}
</style>
