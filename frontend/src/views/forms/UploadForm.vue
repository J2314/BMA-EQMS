<template>
  <ion-content>
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-6">
          <form @submit.prevent="uploadFile" class="add-form">
            <h1 class="form-title">Upload Form</h1>
            <div class="form-group">
              <label for="formName" class="form-label">Form Name:</label>
              <input type="text" id="formName" class="form-control" v-model="fileName" placeholder="Enter form name"
                readonly>
            </div>
            <div class="form-group">
              <label for="department" class="form-label">Department:</label>
              <input type="text" id="department" class="form-control" v-model="departmentName"
                placeholder="Enter department" readonly>
            </div>
            <div class="form-group">
              <label for="file" class="form-label">Choose File:</label>
              <input class="form-control form-control-lg me-3" id="formFileLg" type="file" @change="fileSelected"
                ref="file">
            </div>
            <div class="d-flex align-items-center">
              <button type="submit" class="btn btn-primary btn-lg">Upload</button>
            </div>
          </form>

          <div id="cusTable" class="table-wrapper">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th id="filePath" scope="col">File Path</th>
                  <th scope="col">Date Uploaded</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(upload, index) in formFiles" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ upload.file_path }}</td>
                  <td>{{ formatDate(upload.created_at) }}</td>
                  <td><button id="btnView" type="button" class="btn btn-secondary"
                      @click="openPdf(upload.id)">View</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-6">
          <iframe id="pdfViewer" class="pdf-viewer" ref="pdfViewer" height="100%"></iframe>
        </div>
      </div>
    </div>
  </ion-content>
</template>


<script>
import axios from 'axios';
import { IonApp, IonRouterOutlet, IonButtons, IonContent, IonHeader, IonMenu, IonMenuButton, IonPage, IonTitle, IonToolbar, IonItem } from '@ionic/vue';
export default {
  name: 'UploadForm',
  data() {
    return {
      fileName: '',
      departmentName: '',
      formId: '',
      uploads: [],
      formFiles: [],
      error: '',
      form: {
        file: null
      }
    };
  },
  methods: {
    openPdf(fileId) {
      axios.get(`http://127.0.0.1:8000/api/get-file-content/${fileId}`)
        .then(response => {
          const fileContent = response.data.file.file_path;
          const pdfViewer = this.$refs.pdfViewer;

          pdfViewer.src = fileContent;

          axios.post('http://127.0.0.1:8000/api/increment-view-count', {
            formFileId: fileId
          })
            .then(response => {
              console.log(response.data.message);
            })
            .catch(error => {
              console.error('Error recording view:', error);
            });
        })
        .catch(error => {
          console.error('Error fetching file content:', error);
        });
    },
    async uploadFile() {
      try {
        if (!this.form.file) {
          throw new Error('Please select a file.');
        }

        if (this.form.file.size === 0) {
          throw new Error('File cannot be empty.');
        }

        const formData = new FormData();
        formData.append('file', this.form.file);
        formData.append('form_id', this.formId);

        const response = await axios.post('http://127.0.0.1:8000/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          }
        });

        const newUpload = {
          form_id: response.data.form_id,
          file_path: response.data.file_path,
          created_at: response.data.created_at,
        };

        this.uploads.unshift(newUpload);

        this.form.file = null;

        this.error = '';
        alert('File uploaded successfully!');

        this.retrieveUploads();
      } catch (error) {
        if (error.response && error.response.status === 422) {
          if (error.response.data.error === 'File with the same name already exists') {
            alert('A file with same name already exists.');
          } else {
            this.error = error.response.data.error || 'Validation error.';
          }
        } else {
          this.error = 'Error uploading file.';
          console.error('Error uploading file:', error.message);
        }

        if (error.message === 'Please select a file.') {
          alert('Please select a file.');
        } else if (error.message === 'File cannot be empty.') {
          alert('File cannot be empty.');
        }
      }
    },
    fileSelected(event) {
      const files = event.target.files;
      if (files.length > 0) {
        this.form.file = files[0];
      }
    },
    fetchData() {
      const formId = this.$route.query.formId;
      axios.get(`http://127.0.0.1:8000/api/retrieve-forms/${formId}`)
        .then(response => {
          console.log(response);
          const formData = response.data.form;
          if (formData && formData.file_name && formData.department) {
            this.fileName = formData.file_name;
            this.departmentName = formData.department.name;
            this.formId = formId;
            this.formFiles = formData.form_files || [];
          } else {
            console.error('Invalid response or missing form data:', response.data);
            this.error = 'Invalid response or missing form data.';
          }
        })
        .catch(error => {
          console.error('Error fetching department data:', error);
          this.error = 'Error fetching department data.';
        });
    },
    retrieveUploads() {
      this.fetchData();
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      const year = date.getFullYear();
      let hours = date.getHours();
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const meridiem = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12 || 12;
      const formattedTime = `${hours}:${minutes} ${meridiem}`;
      return `${month}/${day}/${year} ${formattedTime}`;
    }
  },
  mounted() {
    //this.retrieveUploads();
    this.fetchData();
    console.log(this.$route.query.formId)
  },
};
</script>

<style scoped>
.content-wrapper {
  padding: 20px;
  margin-top: 60px;
  overflow-y: auto;
  flex: 1;
}

.add-form {
  max-width: 700px;
  margin-left: 23%;
  margin-right: auto;
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

.btn-secondary {
  background-color: #007bff;
  border-style: none;
  width: 100%;
  height: 40px;
}

.btn-secondary:hover {
  background-color: #0056b3;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.form-title {
  font-size: 32px;
  font-weight: bold;
  color: #333;
  margin-bottom: 30px;
}

#cusTable {
  margin-top: 20px;
  max-width: 700px;
  margin-left: 23%;
  margin-right: auto;
}

.table-hover {
  width: 100%;
  margin-top: 0;
  border-collapse: collapse;
}

.table-hover th,
.table-hover td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
  vertical-align: middle;
}

.table-hover th {
  background-color: #f0f0f0;
}

.form-control-lg {
  width: 100%;
  flex: 1;
}

.align-items-center {
  width: 100%;
  margin-right: 50px;
}

.pdf-viewer {
  position: relative;
  border: 1px solid #ccc;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  display: block;
  width: 100%;
  height: 700px;
  margin-top: 20px;
}

.table-wrapper {
  margin-top: 20px;
  max-height: 325px;
  overflow-y: auto;
}
</style>
