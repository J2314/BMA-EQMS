<template>
  <ion-content class="ion-padding">
    <div class="content-wrapper">
      <form @submit.prevent="submitForm" class="add-form">
        <h1 class="form-title">Add Forms</h1>
        <div class="form-table-container">
          <table class="form-table">
            <tr>
              <td>
                <label for="departmentName" class="form-label">Add Name</label>
                <input type="text" id="departmentName" class="form-control" v-model="file_name"
                  placeholder="Enter name">
              </td>
              <td>
                <label for="departmentCode" class="form-label">Code</label>
                <input type="text" id="departmentCode" class="form-control" v-model="file_code"
                  placeholder="Enter code">
              </td>
              <td>
                <label for="departmentDescription" class="form-label">Description</label>
                <input type="text" id="departmentDescription" class="form-control" v-model="description"
                  placeholder="Enter Description">
              </td>
              <td>
                <label for="departmentId" class="form-label">Department</label>
                <select id="departmentId" class="form-control" v-model="department_id">
                  <option value="">Select Department</option>
                  <option v-for="(department, index) in departments" :key="index" :value="department.id">{{
        department.name }}</option>
                </select>
              </td>
              <td class="button-cell">
                <button type="submit" class="btn btn-primary">Add</button>
              </td>
            </tr>
          </table>
        </div>
        <span v-if="submitSuccess" class="success-message">Form submitted successfully!</span>
        <span v-if="submitError" class="error-message">{{ submitError }}</span>
      </form>
      <table class="form-summary-table">
        <thead>
          <tr>
            <th>Form Name</th>
            <th>Description</th>
            <th>Department</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="form in forms" :key="form.id">
            <td>
              <router-link id="uploadForm"
                :to="{ name: 'uploadForm', params: { formId: form.id, departmentName: form.department.name, fileName: form.file_name } }"
                @click="logFormData(form.id, form.department.name, form.department_id)">
                {{ form.file_name }}
              </router-link>
            </td>
            <td>{{ form.description }}</td>
            <td>{{ form.department.name }}</td>
            <td>
              <button @click="deleteDepartment(form.id)" class="btn btn-danger">Archive</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </ion-content>
</template>

<script>
import axios from 'axios';
import { IonApp, IonRouterOutlet, IonButtons, IonContent, IonHeader, IonMenu, IonMenuButton, IonPage, IonTitle, IonToolbar, IonItem } from '@ionic/vue';

export default {
  name: 'AddFormPage',
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
  data() {
    return {
      file_name: '',
      file_code: '',
      description: '',
      department_id: '',
      submitError: '',
      departments: [],
      forms: [],
    };
  },
  methods: {
    logFormData(formId, departmentName, department_id) {
      console.log('Form ID:', formId);
      console.log('Department ID:', department_id);
      console.log('Department Name:', departmentName);
    },

    submitForm() {
      if (!this.file_name || !this.file_code || !this.department_id || !this.description) {
        this.submitError = 'Please fill out all fields.';
        return;
      }

      axios.post('http://127.0.0.1:8000/api/form', {
        file_name: this.file_name,
        file_code: this.file_code,
        description: this.description,
        department_id: this.department_id,
      })
        .then(() => {
          this.file_name = '';
          this.file_code = '';
          this.description = '';
          this.department_id = '';
          this.submitError = '';
          this.fetchForms();
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.message) {
            this.submitError = error.response.data.message;
          } else {
            this.submitError = 'An error occurred.';
          }
        });
    },
    fetchDepartments() {
      axios.get('http://127.0.0.1:8000/api/retrieve')
        .then(response => {
          this.departments = response.data.filter(department => department.is_Active === true || department.is_Active === 1);
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
        });
    },
    fetchForms() {
      axios.get('http://127.0.0.1:8000/api/retrieve-forms')
        .then(response => {
          this.forms = response.data;
        })
        .catch(error => {
          console.error('Error fetching forms:', error);
        });
    },
    async deleteDepartment(formId) {
      try {
        console.log('Deleting form with ID:', formId);

        await axios.put(`http://127.0.0.1:8000/api/archive-forms/${formId}`);
        alert('Form archived successfully');
        this.fetchForms();
      } catch (error) {
        console.error('Error archiving form:', error.message);
        alert('Error archiving form: ' + error.message);
      }
    },
    getDepartmentName(departmentId) {
      const department = this.departments.find(dep => dep.id === departmentId);
      return department ? department.name : 'Unknown';
    },
  },
  mounted() {
    this.fetchDepartments();
    this.fetchForms();
  }
}
</script>

<style scoped>
.content-wrapper {
  padding: 20px;
  margin-top: 60px;
}

.add-form {
  max-width: 1200px;
  margin: 0 auto;
}

.form-label {
  font-size: 18px;
  color: #333;
}

.form-control {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  margin-bottom: 10px;
  max-height: 200px;
  overflow-y: auto;
}

.btn-primary {
  margin-top: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 12px 20px;
  cursor: pointer;
  transition: background-color 0.3s;
  font-size: 16px;
  width: 100%;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.success-message,
.error-message {
  display: block;
  margin-top: 12px;
  font-size: 16px;
  color: #28a745;
}

.error-message {
  color: #dc3545;
}

.form-title {
  font-size: 32px;
  font-weight: bold;
  color: #333;
  margin-bottom: 30px;
}

.form-table-container {
  overflow-x: auto;
}

.form-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
}

.form-table tr {
  border-bottom: 1px solid #ccc;
}

.form-table td {
  padding: 15px;
}

.button-cell {
  text-align: right;
}

.form-summary-table {
  width: 65%;
  margin-top: 30px;
  margin-left: 18%;
  border-collapse: collapse;
}

.form-summary-table th,
.form-summary-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
}

.form-summary-table th {
  background-color: #f0f0f0;
}

.btn-danger {
  background-color: gray;
  border-style: none;
}

.btn-danger:hover {
  background-color: lightgray;
  color: black;
}

#departmentId {
  width: 110%;
}

#uploadForm {
  text-decoration: none;
}
</style>
