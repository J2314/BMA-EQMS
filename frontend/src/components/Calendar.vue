<template>
  <div class="container">
    <div class="calendar">
      <div class="header">
        <button @click="previousMonth" class="nav-button">&lt;</button>
        <h2>{{ currentMonth }}</h2>
        <button @click="nextMonth" class="nav-button">&gt;</button>
      </div>
      <div class="days">
        <div v-for="day in days" :key="day" class="day">{{ day }}</div>
      </div>
      <div class="dates">
        <div v-for="date in calendarDates" :key="date" class="date">
          {{ date }}
          <div v-for="event in getEventsForDate(date)" :key="event.id" class="event">
            <span class="event-type">{{ event.type === 'timeline' ? 'Timeline' : 'Deadline' }}</span>
            {{ event.content }}
          </div>
        </div>
      </div>

      <div class="add-event-buttons">
        <button @click="openModal('timeline')">Add Timeline</button>
        <button @click="openModal('deadline')">Add Deadline</button>
      </div>
    </div>

    <div class="space"></div>

    <div class="event-section">
      <div class="event-container timeline-container">
        <h2 class="titleko">Timelines</h2>
        <div class="event-cards-container">
          <div v-for="event in filteredTimelines" :key="event.id" class="event-card timeline">
            <h3 class="event-title">{{ event.title }}</h3>
            <p><strong>Date:</strong> {{ event.date }}</p>
            <p><strong>Department:</strong> {{ event.department }}</p>
            <p><strong>Content:</strong> {{ event.content }}</p>
          </div>
        </div>
      </div>

      <div class="event-container deadline-container">
        <h2 class="titleko">Deadlines</h2>
        <div class="event-cards-container">
          <div v-for="event in filteredDeadlines" :key="event.id" class="event-card deadline">
            <h3 class="event-title">{{ event.title }}</h3>
            <p><strong>Date:</strong> {{ event.date }}</p>
            <p><strong>Department:</strong> {{ event.department }}</p>
            <p><strong>Content:</strong> {{ event.content }}</p>
          </div>
        </div>
      </div>
    </div>

    <div v-if="isModalOpen" class="modal">
  <div class="modal-content">
    <span class="close" @click="closeModal">&times;</span>
    <h2 class="modal-title">{{ getModalTitle() }}</h2>

    <div v-if="modalType === 'timeline' || modalType === 'deadline'" class="form-group">
      <label for="eventTitle">{{ modalType === 'timeline' ? 'Title' : 'Title' }}:</label>
      <input type="text" id="eventTitle" v-model="eventTitle" class="form-control" />
    </div>

    <div class="form-group">
      <label for="eventDate">Date:</label>
      <input type="date" id="eventDate" v-model="eventDate" class="form-control" />
    </div>

    <div v-if="modalType !== 'department'" class="form-group">
      <label for="eventDepartment">Department:</label>
      <select id="eventDepartment" v-model="eventDepartment" class="form-control">
        <option value="">Select Department</option>
        <option v-for="(department, index) in departments" :key="index" :value="department.name">{{ department.name }}</option>
      </select>
    </div>

    <div v-if="modalType !== 'department'" class="form-group">
      <label for="eventContent">Content:</label>
      <textarea id="eventContent" v-model="eventContent" placeholder="Event details..." class="form-control"></textarea>
    </div>

    <button @click="addEvent" class="btn btn-primary">Add Event</button>
  </div>
</div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CalendarPage',
  data() {
    return {
      currentDate: new Date(),
      currentMonth: '',
      days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
      calendarDates: [],
      events: [],
      isModalOpen: false,
      modalType: '',
      eventDate: '',
      eventContent: '',
      departments: [],
      eventDepartment: '',
    };
  },
  computed: {
    filteredTimelines() {
      return this.events.filter(event => event.type === 'timeline');
    },
    filteredDeadlines() {
      return this.events.filter(event => event.type === 'deadline');
    },
  },
  mounted() {
    this.updateCalendar();
    this.fetchDepartments();
  },
  methods: {
    updateCalendar() {
      const options = { month: 'long', year: 'numeric' };
      this.currentMonth = this.currentDate.toLocaleDateString('en-US', options);
      this.generateCalendarDates();
    },
    previousMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() - 1);
      this.updateCalendar();
    },
    nextMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() + 1);
      this.updateCalendar();
    },
    generateCalendarDates() {
      const year = this.currentDate.getFullYear();
      const month = this.currentDate.getMonth();
      const daysInMonth = new Date(year, month + 1, 0).getDate();

      this.calendarDates = Array.from({ length: daysInMonth }, (_, i) => i + 1);
    },
    getEventsForDate(date) {
      return this.events.filter(event => event.date === date);
    },
    openModal(type) {
      this.isModalOpen = true;
      this.modalType = type;
      this.eventDate = '';
      this.eventContent = '';
      this.eventDepartment = '';
    },
    closeModal() {
      this.isModalOpen = false;
    },
    addEvent() {
      if (this.eventDate && this.eventContent && this.eventDepartment) {
        const newEvent = {
          id: this.events.length + 1,
          type: this.modalType,
          date: this.eventDate,
          department: this.eventDepartment,
          content: this.eventContent,
        };
        this.events.push(newEvent);
        this.closeModal();
      } else {
        alert('Please fill in all fields.');
      }
    },
    getModalTitle() {
      return this.modalType === 'timeline' ? 'Add Timeline' : this.modalType === 'deadline' ? 'Add Deadline' : 'Add Department';
    },
    fetchDepartments() {
      axios.get('http://127.0.0.1:8000/api/retrieve')
        .then(response => {
          this.departments = response.data;
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
        });
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 100vh;
}

.calendar {
  margin-top: 2%;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  background: linear-gradient(135deg, #f3f3f3, #ffffff);
  text-align: center;
  margin-right: 20px; 
}

.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.nav-button {
  background-color: #ffffff;
  color: #555555;
  border: none;
  font-size: 16px;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}

.nav-button:hover {
  background-color: #f0f0f0;
  color: #333333;
}

.days {
  display: flex;
  justify-content: space-between;
}

.day {
  width: calc(100% / 7);
  padding: 10px;
  text-align: center;
  font-weight: bold;
}

.dates {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 5px;
  text-align: center;
  max-height: 400px;
  overflow-y: auto;
}

.date {
  position: relative;
  padding: 15px;
  border-radius: 15px;
  background-color: #ffffff;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  margin-bottom: 10px;
}

.event {
  margin-top: 5px;
  padding: 5px;
  background-color: #eaeaea;
  border-radius: 5px;
}

.add-event-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
}

.add-event-buttons button {
  margin-right: 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #4caf50;
  color: #fff;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.add-event-buttons button:hover {
  background-color: #ffeb3b;
  color: #333;
}

.modal {
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
  width: 60%; 
  max-width: 500px; 
  position: relative;
}

.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
  position: absolute;
  top: 10px;
  right: 10px;
  transition: color 0.3s ease;
}

.close:hover,
.close:focus {
  color: #333;
}

.modal-title {
  margin-top: 0;
  color: #007bff;
  font-size: 24px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 30px; 
}

.form-control {
  width: 100%;
  padding: 15px; 
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
  font-size: 16px;
  margin-bottom: 20px;
}

textarea {
  resize: vertical;
  height: 100px;
  padding: 15px; 
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
  font-size: 16px;
  margin-bottom: 20px;
}

.btn {
  padding: 15px 30px; 
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  background-color: #4caf50;
  color: #fff;
}

.btn:hover {
  background-color: #ffeb3b;
  color: #333;
}

.event-section {
  display: flex;
  justify-content: space-between;
}

.event-container {
  flex-grow: 1;
  margin-right: 20px;
}

.timeline-container,
.deadline-container {
  margin-top: 5%;
  border: 1px solid #ddd; 
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  background: #f9f9f9;
  height: 545px;
  width: 200px;
  overflow: auto;
}

.event-card {
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 8px;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  background-color: #ffffff;
}

.timeline {
  background-color: #e6f7ff; 
}

.deadline {
  background-color: #ffe6e6;
}

.titleko {
  text-align: center;
}

</style>
