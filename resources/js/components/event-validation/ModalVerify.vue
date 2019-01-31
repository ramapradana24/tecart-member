<template>
  <div
    id="md-verify"
    tabindex="-1"
    data-keyboard="false"
    data-backdrop="static"
    role="dialog"
    class="modal fade"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
            <span class="mdi mdi-close"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-10">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Ticket" v-model="q">
                <span class="text-danger" v-if="error">{{ error }}</span>
              </div>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-block btn-primary btn-lg" @click="search">Search</button>
            </div>
          </div>

          <div class="text-center" v-if="searching">
            <img src="/ripple.svg" height="100px">
          </div>

          <div class="text-center" v-if="!searching && found">
            <p>
              <span class="text-muted text-uppercase">member</span>
              <br>
              {{ going.member.nim_member +' - '+ going.member.nama_member }}
            </p>
            <p>
              <span class="text-muted text-uppercase">event</span>
              <br>
              <span>{{ going.event.event_name }}</span>
              <br>
              <span>{{ going.event.event_location+', '+convertDate(going.event.event_datetime) }}</span>
            </p>

            <button
              class="btn"
              :disabled="going.valid == 1 || loadOnVerif"
              @click="verif(going.going_id)"
              :class="{'btn-primary' : going.valid == 0, 'btn-success': going.valid == 1}"
            >{{ (going.valid == 0) ? verifBtn : 'VERIFIED' }}</button>
          </div>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      q: "",
      error: "",
      searching: false,
      found: false,
      going: {},
      verifBtn: "VERIFY",
      loadOnVerif: false
    };
  },
  methods: {
    search() {
      this.error = "";
      if (this.q == "") {
        this.error = "Fill the ticket first.";
        return;
      }
      this.searching = true;
      this.found = false;

      axios
        .get("/event-validation/" + this.$route.params.id + "?t=" + this.q)
        .then(response => {
          this.searching = false;
          this.found = true;
          this.going = response.data;
        })
        .catch(error => {
          this.searching = false;
          this.error = error.response.data.msg;
        });
    },
    convertDate(date) {
      if (date == "" || date == null) {
        return "";
      }
      return moment(date).format("MMMM Do YYYY h:mm a");
    },
    verif(going) {
      this.loadOnVerif = true;
      this.verifBtn = "loading...";

      axios
        .patch("/event-validation/" + going)
        .then(response => {
          this.loadOnVerif = false;
          this.verifBtn = "VERIFY";
          if (response.data.success) {
            this.$parent.updateGoing = going;
            this.$emit("updateGoing");
            this.going.valid = 1;
          }
        })
        .catch(error => {
          this.loadOnVerif = false;
          this.verifBtn = "VERIFY";
          console.log(error.response.data);
        });
    }
  }
};
</script>
