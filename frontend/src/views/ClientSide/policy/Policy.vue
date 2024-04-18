<template>
  <ion-content>
    <div class="pdf-viewer-container">
      <iframe id="pdfViewer" class="pdf-viewer" ref="pdfViewer"></iframe>
    </div>
  </ion-content>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PdfViewerPage',
  data() {
    return {
      policies: [],
    };
  },
  methods: {
    openPdf(polId) {
      axios.get(`http://127.0.0.1:8000/api/retrieve-policies/${polId}`)
        .then(response => {
          const fileContent = response.data.policy.file_path;
          const pdfViewer = this.$refs.pdfViewer;

          pdfViewer.src = fileContent;
        })
        .catch(error => {
          console.error('Error fetching file content:', error);
        });
    },
  },
  mounted() {
    // Call openPdf method with a sample polId to load an initial PDF, or load the PDF as per your requirement
    // Example: this.openPdf(1);
  }
}
</script>

<style scoped>
.pdf-viewer-container {
  margin-top: 6%;
  margin-left: auto;
  margin-right: auto;
  width: 800px;
  height: 700px;
  border: 1px solid #ccc;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.pdf-viewer {
  width: 100%;
  height: 100%;
}
</style>
