<template>
  <ion-content>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="login-form">
          <div class="text-center mb-4">
            <img src="../assets/bma.png" alt="Logo" class="logo-image-small">
            <h2 class="mb-0"><strong style="font-family: 'Arial Black', sans-serif; font-size: 28px;">BMA e-QMS</strong></h2>
          </div>

          <div>
            <h3 style="font-family: 'Arial', sans-serif; font-size: 20px; font-weight: bold;">Login</h3>
            <hr class="login-divider" />
          </div>
          <div class="alert alert-danger" v-if="error" style="font-family: 'Arial', sans-serif; font-size: 14px;">
            {{ error }}
          </div>
          <form @submit.prevent="onLogin" class="mt-4" ref="loginForm">
            <div class="form-group">
              <label for="email" style="font-family: 'Arial', sans-serif;">Email</label>
              <input type="email" class="form-control" id="email" v-model.trim="formData.email" placeholder="Enter your email" style="font-family: 'Arial', sans-serif; border-color: #b2d8b2;" />
              <div class="error" v-if="errors.email" style="font-size: 0.9rem;">
                {{ errors.email }}
              </div>
            </div>
            <div class="form-group">
              <label for="password" style="font-family: 'Arial', sans-serif;">Password</label>
              <input type="password" class="form-control" id="password" v-model.trim="formData.password" placeholder="Enter your password" style="font-family: 'Arial', sans-serif; border-color: #b2d8b2;" />
              <div class="error" v-if="errors.password" style="font-size: 0.9rem;">
                {{ errors.password }}
              </div>
            </div>
            <div class="text-center my-3">
              <button type="submit" class="btn btn-primary login-btn" style="font-family: 'Arial', sans-serif;" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-else>Login</span>
              </button>
            </div>
          </form>

          <div class="text-center">
            <p style="font-family: 'Arial', sans-serif;">Don't have an account? <router-link :to="{ name: 'Sign Up' }" class="signup-link" style="font-family: 'Arial', sans-serif;" @click="reloadPage('/signup')">Signup</router-link></p>
          </div>
        </div>
      </div>
    </div>
  </ion-content>
</template>

<script>
import axios from 'axios';
import { mapActions, mapMutations } from 'vuex';
import { LOADING_SPINNER_SHOW_MUTATION, LOGIN_ACTION } from '../store/storeconstants';

export default {
  data() {
    return {
      formData: {
        email: '',
        password: '',
      },
      errors: [],
      error: '',
      loading: false,
    };
  },
  methods: {
    ...mapActions('auth', {
      login: LOGIN_ACTION,
    }),
    ...mapMutations({
      showLoading: LOADING_SPINNER_SHOW_MUTATION,
    }),
    async onLogin() {
      try {
        const data = {
          email: this.formData.email,
          password: this.formData.password
        };
        this.showLoading = true;
        await this.login(data);
        this.$router.push('/admin/dashboard');
      } catch (error) {
        this.error = error.message || 'An error occurred while logging in';
      } finally {
        this.showLoading = false;
      }
    },
    reloadPage(path) {
      this.$router.push(path).then(() => {
        window.location.reload();
      });
    },
  },
};
</script>

<style scoped>
.login-form {
  margin-top: 30%;
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
  padding: 30px;
}

.login-divider {
  border-top: 1px solid #ccc;
}

.error {
  color: #dc3545;
}

.signup-link {
  color: #007bff;
  cursor: pointer;
  text-decoration: underline;
}

.logo-image-small {
  max-width: 100px;
}

.form-control:focus {
  border-color: #4caf50 !important;
  box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
}

.login-btn {
  width: 100%;
  background-color: #4caf50;
}

.login-btn:hover {
  background-color: #388e3c;
}

.login-btn:focus {
  background-color: #0056b3;
}

.form-control {
  margin-bottom: 10px;
}
</style>
