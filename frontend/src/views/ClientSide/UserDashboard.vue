<template>
  <ion-content>
    <div class="announcement">
      <h2 class="announcement-title">Latest Announcements</h2>
      <div v-for="(announcement, index) in announcements" :key="index" class="announcement-post">
        <div class="announcement-header">
          <span class="announcement-sender">{{ announcement.sender }} <span class="department"> > {{ announcement.department }}</span></span>
          <span class="announcement-date">{{ formatDate(announcement.date) }}</span>
        </div>
        <div class="announcement-content">
          <p v-if="announcement.showFullContent || announcement.content.length < maxContentLength">
            {{ announcement.content }}
          </p>
          <p v-else>
            {{ announcement.content.substring(0, maxContentLength) }}...
            <button @click="toggleContent(index)" class="view-more">{{ announcement.showFullContent ? 'View Less' : 'View More' }}</button>
          </p>
        </div>
      </div>
    </div>

    <!-- Work Procedures -->
    <div class="work-procedure-placeholder">
      <h2 class="placeholder-title">Work Procedure</h2>
      <div v-for="(procedure, index) in workProcedures" :key="index" class="document-placeholder">
        <h3 class="document-title">{{ procedure.title }}</h3>
        <p class="document-department">Department: {{ procedure.department }}</p>
        <button @click="viewProcedure(procedure)" class="view-button">View</button>
      </div>
    </div>
  </ion-content>
</template>

<script>
export default {
  data() {
    return {
      maxContentLength: 200,
      announcements: [
        {
          sender: "Admin",
          department: "IT Department",
          date: "2024-03-25",
          content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget lectus neque. Integer at libero sed justo aliquam scelerisque vel at libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
          showFullContent: false
        },
        {
          sender: "HR Department",
          department: "Human Resources",
          date: "2024-03-24",
          content: "Short content Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
          showFullContent: false
        },
      ],
      workProcedures: [
        {
          title: "Document Title 1",
          department: "IT Department",
          content: "Procedure content for Document 1."
        },
        {
          title: "Document Title 2",
          department: "Human Resources",
          content: "Procedure content for Document 2."
        }
        // Add more work procedures as needed
      ]
    };
  },
  methods: {
    toggleContent(index) {
      this.announcements[index].showFullContent = !this.announcements[index].showFullContent;
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    viewProcedure(procedure) {
      // Show the full content of the selected work procedure
      alert(procedure.content);
    }
  }
};
</script>

<style scoped>
.announcement {
  margin: 5%;
}

.announcement-title {
  margin-bottom: 10px;
  font-size: 1.5em;
  color: #333;
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

.announcement-content p:last-child {
  margin-bottom: 0;
}

.view-more {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 8px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.view-more:hover {
  background-color: #45a049;
}

.work-procedure-placeholder {
  margin-top: 50px; 
  text-align: left;
  margin-left: 5%;
  margin-right: 5%;
}

.placeholder-title {
  font-size: 1.5em;
  color: #333;
}

.placeholder-text {
  color: #666;
}

.document-placeholder {
  margin-top: 20px; 
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
}

.document-title {
  font-size: 1.2em;
  color: #333;
}

.document-department {
  font-size: 1em;
  color: #666;
}

.view-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 8px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 10px;
}

.view-button:hover {
  background-color: #0056b3;
}
</style>
