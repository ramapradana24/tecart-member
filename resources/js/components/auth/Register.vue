<template>
  <div class="splash-container sign-up">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-heading">
        <img src="tecart-png.png" alt="logo" width="60" class="logo-img">
        <!-- <span class="splash-description">Technology Artisan</span> -->
      </div>
      <div class="panel-body">
        <form action="index.html" method="get">
          <span class="splash-title xs-pb-20">Member Registration</span>

          <div
            role="alert"
            class="alert alert-contrast alert-dismissible"
            v-if="alert"
            :class="{
              'alert-success' :success,
              'alert-danger'  :errorRegist
            }"
          >
            <div class="icon">
              <span
                class="mdi"
                :class="{
              'mdi-check' :success,
              'mdi-close'  :errorRegist
            }"
              ></span>
            </div>
            <div class="message" v-html="alertMsg">
              <button type="button" data-dismiss="alert" aria-label="Close" class="close">
                <span aria-hidden="true" class="mdi mdi-close"></span>
              </button>
              {{ alertMsg }}
            </div>
          </div>

          <div class="form-group">
            <input
              type="number"
              name="nim"
              placeholder="NIM"
              class="form-control"
              v-model="member.nim"
            >

            <p class="text-danger" style="margin-top:5px" v-if="!memberCheck.nim">fill your NIM!</p>
            <p class="text-danger" style="margin-top:5px" v-if="errors.nim">{{ errors.nim[0] }}</p>
          </div>
          <div class="form-group">
            <input
              type="text"
              name="nama"
              placeholder="Nama"
              class="form-control"
              v-model="member.nama"
            >

            <p class="text-danger" style="margin-top:5px" v-if="!memberCheck.nama">fill your name!</p>
            <p class="text-danger" style="margin-top:5px" v-if="errors.name">{{ errors.name[0] }}</p>
          </div>

          <div class="form-group">
            <div class="be-radio inline">
              <input type="radio" name="gender" id="men" value="1" v-model="member.gender">
              <label for="men">
                <img src="assets/img/boy.png" alt="Boy" height="50">
              </label>
            </div>

            <div class="be-radio inline">
              <input type="radio" name="gender" id="women" value="0" v-model="member.gender">
              <label for="women">
                <img src="assets/img/woman.png" alt="Girl" height="50">
              </label>
            </div>

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="!memberCheck.gender || errors.gender"
            >pick one of those gender</p>
          </div>

          <div class="form-group">
            <input
              type="text"
              name="username"
              placeholder="Username"
              class="form-control"
              v-model="member.username"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="!memberCheck.username"
            >fill your username!</p>
            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.username"
            >{{ errors.username[0] }}</p>
          </div>

          <div class="form-group">
            <input
              type="text"
              name="username"
              placeholder="ID LINE"
              class="form-control"
              v-model="member.lineID"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="!memberCheck.lineID || errors.lineID"
            >fill your ID LINE!</p>
          </div>

          <div class="form-group row signup-password">
            <div class="col-xs-6">
              <input
                id="pass1"
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                v-model="member.password"
              >
              <p
                class="text-danger"
                style="margin-top:5px"
                v-if="!memberCheck.password"
              >fill the password</p>

              <p
                class="text-danger"
                style="margin-top:5px"
                v-if="errors.password"
              >{{ errors.password[0] }}</p>
            </div>
            <div class="col-xs-6">
              <input
                type="password"
                placeholder="Confirm"
                name="confirm_password"
                class="form-control"
                v-model="member.password_confirmation"
              >
              <p
                class="text-danger"
                style="margin-top:5px"
                v-if="!memberCheck.confirm_password || errors.password_confirmation"
              >fill the password confirmation</p>
            </div>
          </div>

          <div class="form-group xs-pt-10">
            <button
              type="button"
              style="margin-bottom:20px;"
              class="btn btn-block btn-primary btn-xl"
              @click="signUp"
              :disabled="signUpButtonStatus"
            >{{ signUpButtonMsg }}</button>
            <span>Already have an account?
              <router-link to="/login">Login!</router-link>
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
      signUpButtonMsg: "Sign Up",
      signUpButtonStatus: false,
      member: {
        nim: "",
        nama: "",
        username: "",
        password: "",
        password_confirmation: "",
        gender: "",
        tac: "",
        lineID: ""
      },
      memberCheck: {
        nim: true,
        nama: true,
        username: true,
        password: true,
        confirm_password: true,
        gender: true,
        tac: true,
        lineID: true
      },
      allClear: true,
      errors: {},
      success: false,
      errorRegist: false,
      alert: false,
      alertMsg: ""
    };
  },
  methods: {
    signUp() {
      this.success = this.errorRegist = this.alert = false;

      this.allClear = true;
      if (this.member.nim == "") {
        this.memberCheck.nim = false;
        this.allClear = false;
      } else this.memberCheck.nim = true;

      if (this.member.nama == "") {
        this.memberCheck.nama = false;
        this.allClear = false;
      } else this.memberCheck.nama = true;

      if (this.member.gender == "") {
        this.memberCheck.gender = false;
        this.allClear = false;
      } else this.memberCheck.gender = true;

      if (this.member.username == "") {
        this.memberCheck.username = false;
        this.allClear = false;
      } else this.memberCheck.username = true;

      if (this.member.lineID == "") {
        this.memberCheck.lineID = false;
        this.allClear = false;
      } else this.memberCheck.lineID = true;

      if (this.member.password == "") {
        this.memberCheck.password = false;
        this.allClear = false;
      } else this.memberCheck.password = true;

      if (this.member.confirm_password == "") {
        this.memberCheck.confirm_password = false;
        this.allClear = false;
      } else this.memberCheck.confirm_password = true;

      if (this.allClear) {
        if (this.signUpButtonStatus) {
          this.signUpButtonMsg = "Sign Up";
          this.signUpButtonStatus = false;
        } else {
          this.signUpButtonMsg = "loading...";
          this.signUpButtonStatus = true;
        }

        this.sendRegistrationData();
      }
    },
    sendRegistrationData() {
      axios
        .post("/regist", this.member)
        .then(response => {
          this.errors = {};
          this.alertMsg =
            '<strong>Good!</strong> Register success.<b><a href="/login" style="color:#ffffff">Click here</a></b> to go to Login Page.';
          this.alert = this.success = true;
          this.signUpButtonMsg = "Sign Up";
          this.signUpButtonStatus = false;
        })
        .catch(error => {
          if (error.response.data.error)
            this.errors = error.response.data.error;
          else {
            this.alertMsg = "Oops! There is something wrong with our server.";
            this.alert = this.errorRegist = true;
          }
          this.signUpButtonMsg = "Sign Up";
          this.signUpButtonStatus = false;
        });
    }
  }
};
</script>
