<template>
  <div class="container">
    <div class="user-table">
      <h3>User Table</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th> 
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="index">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>
              <span v-for="(role, i) in user.roles" :key="i" class="role">{{ role }}</span>
            </td>
            <td>
              <button @click="addRole(index)" class="button add-role green-button">Add Role</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="create-role-section">
      <h3>Create Role</h3>
      <div>
        <input v-model="newRoleName" type="text" placeholder="Enter role name" class="role-input">
        <button @click="createRole" class="button create-role green-button">Create Role</button>
      </div>
    </div>
    <div class="activity-log">
      <h3>Activity Log</h3>
      <table class="log-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>User</th>
            <th>Activity</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(log, index) in activityLog" :key="index">
            <td>{{ log.date }}</td>
            <td>{{ log.user }}</td>
            <td>{{ log.activity }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'MonitoringPage',
  data() {
    return {
      users: [
        { name: 'John Doe', email: 'john@example.com', roles: ['Admin'] },
        { name: 'Jane Smith', email: 'jane@example.com', roles: ['User'] },
        { name: 'Placeholder User', email: 'placeholder@example.com', roles: ['Guest'] }
      ],
      newRoleName: '',
      activityLog: [
        { date: new Date(), user: 'John Doe', activity: 'Logged in' },
        { date: new Date(), user: 'Jane Smith', activity: 'Viewed dashboard' },
        { date: new Date(), user: 'Placeholder User', activity: 'Performed action' }
      ]
    };
  },
  methods: {
    addRole(index) {
      this.users[index].roles.push('New Role');
      this.activityLog.push({ date: new Date(), user: this.users[index].name, activity: 'Added a new role' });
    },
    createRole() {
      if (this.newRoleName) {
        this.users.forEach(user => {
          user.roles.push(this.newRoleName);
        });
        this.newRoleName = '';
        this.activityLog.push({ date: new Date(), user: 'System', activity: `New role "${this.newRoleName}" created` });
      }
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 60px auto 20px; 
}

.create-role-section {
  margin-bottom: 20px;
}

.create-role-section h3 {
  margin-bottom: 10px;
  font-size: 20px;
  font-weight: bold;
}

.role-input {
  width: 200px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.user-table h3 {
  margin-top: -4%;
  margin-bottom: 10px;
  font-size: 20px;
  font-weight: bold;
}

.activity-log h3 {
  margin-top: 5%;
  margin-bottom: 10px;
  font-size: 20px;
  font-weight: bold;
}

.table {
  margin-bottom: 5%;
  width: 100%;
  border-collapse: collapse;
}

.table th, .table td {
  padding: 8px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

.table th {
  background-color: #f5f5f5;
}

.table tr:hover {
  background-color: #f2f2f2;
}

.log-table {
  width: 100%;
  border-collapse: collapse;
}

.log-table th, .log-table td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: left;
}

.log-table th {
  background-color: #f5f5f5;
}

.log-table tr:nth-child(even) {
  background-color: #f2f2f2;
}

.log-table tr:hover {
  background-color: #e6e6e6;
}

.green-button {
  background-color: #2ecc71;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
}

.green-button:hover {
  background-color: #27ae60;
}
</style>
