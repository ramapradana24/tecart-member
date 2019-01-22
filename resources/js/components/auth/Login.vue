<template>
  <div class="splash-container sign-up">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading">
        <img src="tecart-png.png" alt="logo" width="60" class="logo-img">
        <!-- <span class="splash-description">Technology Artisan</span> -->
      </div>
      <div class="panel-body">
        <form action="/login" method="post" v-on:keyup.enter="login">
          <span class="splash-title xs-pb-20">Login</span>
          <div
            role="alert"
            class="alert alert-contrast alert-dismissible"
            v-if="alert"
            v-bind:class="getAlertClass()"
          >
            <div class="icon">
              <span
                class="mdi"
                v-bind:class="{
                  'mdi-check': this.success,
                  'mdi-close': this.systemError
                }"
              ></span>
            </div>
            <div class="message">{{ alertMessage }}</div>
          </div>

          <div class="form-group">
            <input
              type="text"
              name="username"
              required
              placeholder="Username"
              class="form-control"
              v-model="credentials.username"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.username"
            >{{ errors.username[0] }}</p>
          </div>
          <div class="form-group">
            <input
              type="password"
              name="password"
              required
              placeholder="Password"
              class="form-control"
              v-model="credentials.password"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.password"
            >{{ errors.password[0] }}</p>
          </div>

          <div class="form-group xs-pt-10">
            <button
              type="button"
              class="btn btn-block btn-primary btn-xl"
              style="margin-bottom:20px;"
              @click="login"
              :disabled="loginBtnMsg != 'Login'"
            >{{ loginBtnMsg }}</button>
            <span>Not registered yet?
              <router-link to="/register">Register Here!</router-link>
            </span>
          </div>
        </form>
      </div>
    </div>
    <div class="splash-footer">&copy; 2018 Technology Artisan</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: {
        username: [],
        password: []
      },
      credentials: {
        username: "",
        password: ""
      },
      anyErrors: false,
      success: false,
      systemError: false,
      alert: false,
      alertMessage: "",
      loginBtnMsg: "Login"
    };
  },
  methods: {
    getAlertClass() {
      return {
        "alert-success": this.success,
        "alert-danger": this.systemError
      };
    },
    login() {
      this.success = false;
      this.systemError = false;
      this.alert = false;
      this.anyErrors = false;
      this.errors = {
        username: [],
        password: []
      };
      if (this.credentials.username == "") {
        this.errors.username = ["Please fill the username"];
        this.anyErrors = true;
      }

      if (this.credentials.password == "") {
        this.errors.password = ["Please fill the password"];
        this.anyErrors = true;
      }

      if (!this.anyErrors) {
        this.loginBtnMsg = "loading...";
        axios
          .post("/login", this.$data.credentials)
          .then(response => {
            this.success = true;
            this.alert = true;
            this.alertMessage = "Login Success. Redirecting...";
            window.location = "/";
            this.loginBtnMsg = "Login";
          })
          .catch(error => {
            this.loginBtnMsg = "Login";
            this.credentials.password = "";
            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
            } else {
              this.alert = true;
              this.alertMessage = "System Error!";
              this.systemError = true;
            }
          });
      }
    }
  }
};
</script>
