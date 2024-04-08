<template>
    <ion-content>
      <div class="department-forms">
        <h2 class="forms-title">Department Forms</h2>
        <div v-if="departmentForms.length === 0" class="placeholder">
          <p>No department forms available at the moment. Please check back later.</p>
        </div>
        <div v-else>
          <!-- Render department forms here -->
          <div v-for="(form, index) in departmentForms" :key="index" class="form-container">
            <div class="announcement-post">
              <div class="announcement-header">
                <span class="announcement-sender">{{ form.title }} <span class="department"> > {{ form.department }}</span></span>
                <span class="announcement-date">{{ formatDate(form.publishedDate) }}</span>
              </div>
              <div class="announcement-content">
                <!-- Placeholder for content -->
                <p>{{ form.description }}</p>
              </div>
              <!-- Add a placeholder for PDF viewer -->
              <div class="pdf-placeholder">
                <ion-icon name="document"></ion-icon>
                <p>{{ form.title }}</p>
              </div>
              <!-- Add view and download buttons below the content -->
              <div class="form-actions">
                <ion-button @click="viewPDF(form.url)" color="primary" fill="outline">View</ion-button>
                <ion-button @click="downloadPDF(form.url)" color="success" fill="outline">Download</ion-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </ion-content>
  </template>
  
  <script>
  export default {
    data() {
      return {
        departmentForms: [
          { title: "Form 1", department: "IT Department", publishedDate: "2024-04-05", description: "Form 1 description", url: "/path/to/form1.pdf" },
          { title: "Form 2", department: "HR Department", publishedDate: "2024-04-06", description: "Form 2 description", url: "/path/to/form2.pdf" },
          // Add more form objects as needed
        ]
      };
    },
    methods: {
      viewPDF(url) {
        // Implement view PDF functionality
      },
      downloadPDF(url) {
        // Implement download PDF functionality
      },
      formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
      }
    }
  };
  </script>
  
  <style scoped>
  .department-forms {
    margin: 5%;
  }
  
  .forms-title {
    margin-bottom: 20px;
    font-size: 1.5em;
    color: #333;
  }
  
  .placeholder {
    margin-top: 20px;
    text-align: center;
    color: #666;
  }
  
  .placeholder p {
    font-size: 1.2em;
  }
  
  .form-container {
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }
  
  .announcement-post {
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
  }
  
  .announcement-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  
  .announcement-sender {
    font-weight: bold;
    color: #333;
  }
  
  .department {
    font-weight: normal;
    color: #666;
  }
  
  .announcement-date {
    color: #666;
  }
  
  .announcement-content {
    line-height: 1.5;
  }
  
  .pdf-placeholder {
    text-align: center;
    margin-top: 10px;
  }
  
  .pdf-placeholder ion-icon {
    font-size: 64px;
    color: #ccc;
  }
  
  .pdf-placeholder p {
    margin-top: 10px;
    font-size: 1.2em;
    color: #666;
  }
  
  .form-actions {
    margin-top: 10px;
  }
  </style>
  