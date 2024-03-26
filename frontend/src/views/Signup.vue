<template>
  <ion-content>
    <div class="row justify-content-center">
      <div class="col-md-4"> <!-- Adjust the width of the signup form -->
        <div class="signup-form">
          <div class="text-center mb-4">
            <img src="../assets/bma.png" alt="Logo" class="logo-image-small">
            <h2 class="mb-0"><strong style="font-family: 'Arial Black', sans-serif; font-size: 28px;">BMA e-QMS</strong></h2>
          </div>

          <div>
            <h3 style="font-family: 'Arial', sans-serif; font-size: 20px; font-weight: bold;">Signup</h3>
            <hr class="signup-divider" />
          </div>
          <div class="alert alert-danger" v-if="error" style="font-family: 'Arial', sans-serif; font-size: 14px;">
            {{ error }}
          </div>
          <form @submit.prevent="onSignup()" class="mt-4">
            <div class="form-group">
              <label for="name" style="font-family: 'Arial', sans-serif;">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model.trim="name"
                placeholder="Enter your name"
                style="font-family: 'Arial', sans-serif;"
              />
              <div class="error" v-if="errors.name" style="font-size: 0.9rem;">
                {{ errors.name }}
              </div>
            </div>
            <div class="form-group">
              <label for="email" style="font-family: 'Arial', sans-serif;">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                v-model.trim="email"
                placeholder="Enter your email"
                style="font-family: 'Arial', sans-serif;"
              />
              <div class="error" v-if="errors.email" style="font-size: 0.9rem;">
                {{ errors.email }}
              </div>
            </div>
            <div class="form-group">
              <label for="password" style="font-family: 'Arial', sans-serif;">Password</label>
              <input
                type="password"
                class="form-control"
                id="password"
                v-model.trim="password"
                placeholder="Enter your password"
                style="font-family: 'Arial', sans-serif;"
              />
              <div class="error" v-if="errors.password" style="font-size: 0.9rem;">
                {{ errors.password }}
              </div>
            </div>

            <div class="text-center my-3">
              <button type="submit" class="btn btn-primary signup-btn" style="font-family: 'Arial', sans-serif;">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-else>Signup</span>
              </button>
            </div>

            <div class="text-center">
              <p style="font-family: 'Arial', sans-serif;">Already have an account? <router-link to="/login" class="login-link" style="font-family: 'Arial', sans-serif;" @click="reloadPage">Login</router-link></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </ion-content>
</template>

<script>
import axios from 'axios';
import { mapActions, mapMutations } from 'vuex';
import SignupValidations from '../services/SignupValidations';
import {
  LOADING_SPINNER_SHOW_MUTATION,
  SIGNUP_ACTION,
} from '../store/storeconstants';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      errors: [],
      error: '',
      loading: false,
    };
  },
  methods: {
    ...mapActions('auth', {
      signup: SIGNUP_ACTION,
    }),
    ...mapMutations({
      showLoading: LOADING_SPINNER_SHOW_MUTATION,
    }),
    async onSignup() {
      let validations = new SignupValidations(
        this.email,
        this.password,
      );

      this.errors = validations.checkValidations();
      if (this.errors.length) {
        return false;
      }
      this.error = '';

      this.loading = true;

      try {
        let response = await axios.post('http://127.0.0.1:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        });
        console.log(response.data);
        this.$router.push('/login');
      } catch (error) {
        this.error = error.message || 'An error occurred while signing up';
      } finally {
        this.loading = false;
      }
    },
    reloadPage() {
      window.location.reload(); // Reload the page after clicking the login link
    }
  },
};
</script>

<style scoped>
.signup-form {
  margin-top: 20%;
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
  padding: 30px;
}

.signup-divider {
  border-top: 1px solid #ccc;
}

.error {
  color: #dc3545;
  font-size: 0.9rem;
}

.signup-btn {
  width: 100%;
  background-color: #4caf50;
}

.signup-btn:hover {
  background-color: #388e3c;
}

.signup-btn:focus {
  background-color: #0056b3;
}

.login-link {
  color: #007bff;
  cursor: pointer;
  text-decoration: underline;
}

.logo-image-small {
  max-width: 100px;
}

.form-control {
  margin-bottom: 10px;
}
</style>
