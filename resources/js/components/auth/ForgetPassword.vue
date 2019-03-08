<template>
  <div class="splash-container sign-up">
    <div class="panel panel-default panel-border-color panel-border-color-primary">
      <div class="panel-body" v-show="!isFound">
        <h4 style="font-weight:bold">Search Your Account</h4>
        <small>Type your username or student ID (NIM) to search your account. Make sure that you already set your email. If it is not, please contact this website admin.</small>

        <form action="#" style="margin-top:20px">
          <input type="text" v-model="q" class="form-control" placeholder="username or NIM">
          <p class="text-danger" style="margin-top:5px" v-if="errMsg">{{ errMsg }}</p>
          <button
            @click="search"
            type="button"
            style="margin:18px auto;display:block"
            class="btn btn-info"
            :disabled="btnSearchTxt != 'Search'"
          >{{ btnSearchTxt }}</button>
        </form>
      </div>

      <div class="panel-body" v-if="isFound">
        <h4 style="font-weight:bold">User Found!</h4>
        <small>Congratulations! your account found. Below is your account details. Password reset link will be send to your email address by click at Send Password Reset Link button. We cant send the link if email is not available.</small>

        <table style="margin-top:20px">
          <tr>
            <td width="30%">Name</td>
            <td>:</td>
            <td class="text-bold">{{ user.nama_member }}</td>
          </tr>
          <tr>
            <td>NIM</td>
            <td>:</td>
            <td class="text-bold">{{ user.nim_member }}</td>
          </tr>
          <tr>
            <td>Username</td>
            <td>:</td>
            <td class="text-bold">{{ user.username }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td
              class="text-bold"
            >{{ (user.email) ? user.email : "cant send link because email is missing" }}</td>
          </tr>
        </table>

        <div style="margin:18px auto;display:block">
          <button
            type="button"
            class="btn btn-info"
            :disabled="user.email == null"
          >Send Password Reset Link</button>
          <button type="button" class="btn btn-default" @click="isFound = false">Search Again</button>
        </div>
      </div>
    </div>
    <div class="splash-footer">&copy; 2018 Technology Artisan</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      q: "",
      btnSearchTxt: "Search",
      errMsg: "",
      isFound: false,
      user: []
    };
  },
  methods: {
    search() {
      this.errMsg = "";
      this.btnSearchTxt = "Searching";
      axios
        .post("/forget-pass", { q: this.q })
        .then(res => {
          if (!res.data.success) {
            //   not found
            this.isErr = true;
            this.errMsg = res.data.msg;
          } else {
            console.log("found");
            this.isFound = true;
            this.user = res.data.user;
          }
        })
        .catch(err => {
          console.log(err.data);
        })
        .finally(() => {
          this.btnSearchTxt = "Search";
        });
    }
  }
};
</script>