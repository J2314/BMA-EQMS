<template>
    <ion-content>
  <div class="login-page" >
    <div class="login-container">
      <div class="logo">
        <img src="../assets/bma.png" alt="Logo" class="logo-image">
      </div>
      <h1 class="page-title">BMA E-QMS</h1>
      <p class="login-label">Login</p>
      <div class="alert alert-danger" v-if="error">{{ error }}</div>
      <form class="login-form" @submit.prevent="onLogin()">
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" placeholder="Enter your email" class="input-field" v-model.trim="email">
          <div class="error" v-if="errors.email">{{ errors.email }}</div>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" placeholder="Enter your password" class="input-field"
            v-model.trim="password">
          <div class="error" v-if="errors.password">{{ errors.password }}</div>
        </div>
        <div class="additional-options">
          <label for="remember-me" class="remember-checkbox" style="margin-top: 5px;">
            <input id="remember-me" type="checkbox"> Remember Me
          </label>
          <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <button type="submit" class="login-button">Login</button>
        <div class="signup-section">
          <p>Don't have an account? <router-link to="/signup" class="signup-link">Sign up</router-link></p>
        </div>
      </form>
    </div>
  </div>
</ion-content>
</template>


<script>
import { mapMutations } from 'vuex';
import SignupValidations from '../services/SignupValidations';
import { LOADING_SPINNER_SHOW_MUTATION } from '../store/storeconstants';
import axios from 'axios';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      errors: [],
      error: '',
    };
  },
  methods: {
    ...mapMutations({
      showLoading: LOADING_SPINNER_SHOW_MUTATION,
    }),
    async onLogin() {
      let validations = new SignupValidations(
        this.email,
        this.password,
      );

      this.errors = validations.checkValidations();
      if (this.errors.length) {
        return false;
      }
      this.error = '';
      this.showLoading(true);
      const data = {
        email: this.email,
        password: this.password
      }
      console.log(data)
      try {
        await axios.post('http://127.0.0.1:8000/api/login', data);
        this.$router.push('/dashboard');
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.error = error.response.data.message;
        } else {
          this.error = 'An error occurred while logging in.';
        }
      }
      this.showLoading(false);
    },
  },
};
</script>

<style scoped>
.login-page {
  margin-top: 1.5%;
  display: flex;
  justify-content: center;
  align-items: center;
  height: calc(100vh - 30px);
}

.login-container {
  border-radius: 15px;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
  padding: 30px;
  width: 400px;
  background-color: #fff;
}

.logo {
  text-align: center;
  margin-bottom: 20px;
}

.logo-image {
  width: 120px;
}

.page-title {
  font-family: 'Merriweather', serif;
  font-size: 24px;
  margin-bottom: 20px;
  color: #087f23;
  text-align: center;
}

.login-label {
  color: #555;
  text-align: center;
  margin-bottom: 20px;
  font-weight: bold;
  text-transform: uppercase;
  font-size: 20px;
}

.login-form {
  width: 100%;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-weight: bold;
  margin-bottom: 10px;
  font-size: 16px;
  color: #333;
}

.input-field {
  padding: 12px;
  width: 100%;
  border: 2px solid #4CAF50;
  border-radius: 8px;
  font-size: 16px;
}

.input-field:focus {
  outline: none;
  border-color: #087f23;
}

.remember-checkbox {
  margin-right: 10px;
  font-size: 16px;
}

.additional-options {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.forgot-password {
  color: #087f23;
  text-decoration: none;
  font-size: 16px;
}

.forgot-password:hover {
  text-decoration: underline;
}

.login-button {
  padding: 14px 24px;
  background-color: #087f23;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.3s ease;
}

.login-button:hover {
  background-color: #005711;
}

.signup-section {
  text-align: center;
  margin-top: 20px;
}

.signup-link {
  color: #087f23;
  text-decoration: none;
  font-size: 16px;
}

.signup-link:hover {
  text-decoration: underline;
}

p {
  font-size: 16px;
}
</style>
