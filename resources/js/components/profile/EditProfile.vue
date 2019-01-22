<template>
  <div
    id="md-default"
    data-keyboard="false"
    data-backdrop="static"
    role="dialog"
    class="modal fade colored-header colored-header-primary"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="close" aria-hidden="true" class="close">
            <span class="mdi mdi-close"></span>
          </button>
          <h3 class="modal-title text-uppercase">edit profile</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>NIM</label>
            <input
              type="number"
              placeholder="Enter email"
              class="form-control"
              v-model="userProfile.nim_member"
            >
            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.nim_member"
            >{{ errors.nim_member[0] }}</p>
          </div>

          <div class="form-group">
            <label>ID LINE</label>
            <input
              type="text"
              placeholder="Enter email"
              class="form-control"
              v-model="userProfile.id_line"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.id_line"
            >{{ errors.id_line[0] }}</p>
          </div>

          <div class="form-group">
            <label>Name</label>
            <input
              type="text"
              placeholder="Enter email"
              class="form-control"
              v-model="userProfile.nama_member"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.nama_member"
            >{{ errors.nama_member[0] }}</p>
          </div>

          <div class="form-group">
            <label>Username</label>
            <input
              type="text"
              placeholder="Enter email"
              class="form-control"
              v-model="userProfile.username"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.username"
            >{{ errors.username[0] }}</p>
          </div>

          <div class="form-group">
            <div class="be-radio inline">
              <input type="radio" name="gender" value="1" id="men" v-model="userProfile.jk_member">
              <label for="men">
                <img src="assets/img/boy.png" alt="Boy" height="50">
              </label>
            </div>

            <div class="be-radio inline">
              <input
                type="radio"
                name="gender"
                value="0"
                id="women"
                v-model="userProfile.jk_member"
              >
              <label for="women">
                <img src="assets/img/woman.png" alt="Girl" height="50">
              </label>
            </div>
          </div>

          <div class="form-group">
            <label>Interest</label>
            <select
              class="select2"
              id="interest"
              style="width:100%"
              v-model="userProfile.interest_id"
            >
              <option
                v-for="item, key in interests"
                :value="item.interest_id"
              >{{ item.interest_name }}</option>
            </select>

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.interest_id"
            >{{ errors.interest_id[0] }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" @click="close" class="btn btn-space btn-default">Cancel</button>
          <button
            type="button"
            class="btn btn-space btn-primary"
            @click="update"
            :disabled="proceedBtn != 'Proceed'"
          >{{ proceedBtn }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["openmodal"],
  data() {
    return {
      userProfile: {},
      temp: {},
      interests: {},
      errors: {},
      proceedBtn: "Proceed",
      anyError: false
    };
  },
  watch: {
    openmodal() {
      if (this.openmodal) {
        $(".select2").select2();
      }
    }
  },
  mounted() {
    $(".select2").select2();
  },
  methods: {
    update() {
      this.anyError = false;
      this.userProfile.interest_id = document.getElementById("interest").value;
      this.proceedBtn = "loading..";
      axios
        .patch("/profile/" + this.userProfile.member_id, this.userProfile)
        .then(response => {
          this.proceedBtn = "Proceed";
          this.$parent.user = response.data.user;
          this.close();
        })
        .catch(error => {
          this.proceedBtn = "Proceed";
          this.errors = error.response.data.error;
          this.anyError = true;
        });
    },
    close() {
      this.$emit("closeRequest");
      this.errors = {};
      if (this.anyError) this.$parent.user = this.temp;
    }
  }
};
</script>