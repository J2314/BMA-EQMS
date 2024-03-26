<template>
  <ion-router-outlet id="main-content"></ion-router-outlet>
  <div class="container">
    <div class="chart-container">
      <div class="chart">
        <h3>Form Viewing Count</h3>
        <canvas ref="formViewCountChart" width="300" height="150"></canvas>
      </div>
      <div class="chart">
        <h3>Downloading Count</h3>
        <canvas ref="downloadingCountChart" width="300" height="150"></canvas>
      </div>
      <div class="chart">
        <h3>Monthly Trends</h3>
        <canvas ref="monthlyTrendsChart" width="300" height="150"></canvas>
      </div>
      <div class="chart">
        <h3>Distribution</h3>
        <canvas ref="distributionChart" width="300" height="150"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonButtons, IonMenuButton, IonRouterOutlet } from '@ionic/vue';
import Chart from 'chart.js/auto';

export default {
  name: 'MonitoringPage',
  components: {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonButtons,
    IonMenuButton,
    IonRouterOutlet
  },
  data() {
    return {
      formViewCounts: [100, 200, 300, 400, 500],
      downloadingCounts: [50, 150, 250, 350, 450],
      monthlyTrendsData: [
        { month: 'January', formViews: 120, downloads: 50 },
        { month: 'February', formViews: 180, downloads: 80 },
        { month: 'March', formViews: 250, downloads: 120 },
        { month: 'April', formViews: 320, downloads: 200 },
        { month: 'May', formViews: 400, downloads: 250 },
      ],
      distributionData: {
        labels: ['Category A', 'Category B', 'Category C'],
        data: [30, 45, 25],
      },
    };
  },
  mounted() {
    this.renderFormViewCountChart();
    this.renderDownloadingCountChart();
    this.renderMonthlyTrendsChart();
    this.renderDistributionChart();
  },
  methods: {
    renderFormViewCountChart() {
      const ctx = this.$refs.formViewCountChart.getContext('2d');
      new Chart(ctx, {
        type: 'bar', // Change type to 'bar'
        data: {
          labels: ['January', 'February', 'March', 'April', 'May'],
          datasets: [{
            label: 'Form View Count',
            data: this.formViewCounts,
            backgroundColor: 'rgb(75, 192, 192)',
            borderWidth: 1,
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    renderDownloadingCountChart() {
      const ctx = this.$refs.downloadingCountChart.getContext('2d');
      new Chart(ctx, {
        type: 'bar', // Change type to 'bar'
        data: {
          labels: ['January', 'February', 'March', 'April', 'May'],
          datasets: [{
            label: 'Downloading Count',
            data: this.downloadingCounts,
            backgroundColor: 'rgb(255, 99, 132)',
            borderWidth: 1,
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    renderMonthlyTrendsChart() {
      const ctx = this.$refs.monthlyTrendsChart.getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: this.monthlyTrendsData.map(data => data.month),
          datasets: [
            {
              label: 'Form Views',
              backgroundColor: 'rgb(75, 192, 192)',
              data: this.monthlyTrendsData.map(data => data.formViews),
            },
            {
              label: 'Downloads',
              backgroundColor: 'rgb(255, 99, 132)',
              data: this.monthlyTrendsData.map(data => data.downloads),
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    },
    renderDistributionChart() {
      const ctx = this.$refs.distributionChart.getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: this.distributionData.labels,
          datasets: [
            {
              data: this.distributionData.data,
              backgroundColor: ['#007bff', '#28a745', '#ffc107'],
            },
          ],
        },
      });
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 60px auto 20px; 
}

.chart-container {
  margin-top: -4%;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.chart {
  padding: 20px;
  border-radius: 8px;
}

.chart h3 {
  font-size: 20px;
  color: #007bff;
  font-weight: bold;
  margin-top: 0;
  margin-bottom: 10px;
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
</style>
