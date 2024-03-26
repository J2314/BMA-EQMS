<template>
  <ion-content>
  <div>
    <div class="content-wrapper">
      <form @submit.prevent="submitForm" class="add-form">
        <h1 class="form-title">Add Department</h1>
        <div class="form-table-container">
          <table class="form-table">
            <tr>
              <td>
                <label for="departmentName" class="form-label">Department Name</label>
                <input type="text" id="departmentName" class="form-control" v-model="departmentName" placeholder="Enter name">
              </td>
              <td>
                <label for="departmentCode" class="form-label">Department Code</label>
                <input type="text" id="departmentCode" class="form-control" v-model="departmentCode" placeholder="Enter code">
              </td>
              <td class="button-cell" colspan="2">
                <button type="submit" class="btn btn-primary">Add</button>
              </td>
            </tr>
          </table>
        </div>
        <span v-if="submitError" class="error-message">{{ submitError }}</span>
      </form>
      <table class="form-summary-table">
          <thead>
            <tr>
              <th>Department Name</th>
              <th>Department Code</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="department in departments" :key="department.id">
              <td>{{ department.name }}</td>
              <td>{{ department.code }}</td>
              <td>
                  <button @click="deleteDepartment(department.id)" class="btn btn-danger">Archive</button>
              </td>
          </tr>
          </tbody>
        </table>
    </div>
  </div>
</ion-content>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AddDepartmentPage',
  data() {
    return {
      departmentName: '',
      departmentCode: '',
      submitError: '',
      departments: [], 
      is_Active: true 
    };
  },
  methods: {
    submitForm() {
      if (!this.departmentName || !this.departmentCode) {
        this.submitError = 'Please fill out all fields.';
        return;
      }

      axios.post('http://127.0.0.1:8000/api/department', {
        name: this.departmentName,
        code: this.departmentCode,
        is_Active: this.is_Active
      })
      .then(() => {
        this.departments.push({
          name: this.departmentName,
          code: this.departmentCode,
          is_Active: this.is_Active
        });

        this.departmentName = '';
        this.departmentCode = '';
        this.submitError = '';
      })
      .catch(error => {
        if (error.response && error.response.data && error.response.data.message) {
          this.submitError = error.response.data.message;
        } else {
          this.submitError = 'An error occurred.';
        }
      });
    },
    async deleteDepartment(depId) {
        try {
          console.log('Deleting department with ID:', depId);

          await axios.put(`http://127.0.0.1:8000/api/archive/${depId}`);
          alert('Department archived successfully');
          this.fetchDepartments();
        } catch (error) {
          console.error('Error archiving department:', error.message);
          alert('Error archiving department: ' + error.message);
        }
      },
        fetchDepartments() {
      axios.get('http://127.0.0.1:8000/api/retrieve')
        .then(response => {
          this.departments = response.data;
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
        });
    }
  },
  mounted() {
    this.fetchDepartments();
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
  }
  
  .btn-primary {
    margin-top: 22px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 16px;
  }
  
  .btn-primary:hover {
    background-color: #0056b3;
  }
  
  .btn-danger {
    background-color: gray;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 14px;
  }
  
  .btn-danger:hover {
    background-color: lightgray;
    color: black;
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
    margin-left: 18%;
    margin-top: 30px;
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
  </style>
