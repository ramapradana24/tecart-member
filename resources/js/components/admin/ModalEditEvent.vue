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
          <h3 class="modal-title text-uppercase">edit Event</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="event.event_name">
            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.event_name"
            >{{ errors.event_name[0] }}</p>
          </div>

          <div class="form-group">
            <label>Interest</label>
            <select
              class="select2"
              id="interest_edit"
              style="width:100%"
              v-model="event.interest_id"
            >
              <option
                v-for="(item, key) in interests"
                :value="item.interest_id"
                :key="key"
              >{{ item.interest_name }}</option>
            </select>

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.interest_id"
            >{{ errors.interest_id[0] }}</p>
          </div>

          <div class="form-group">
            <label>Points</label>
            <input type="number" class="form-control" v-model="event.event_pts">

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.event_pts"
            >{{ errors.event_pts[0] }}</p>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" rows="5" v-model="event.event_desc"></textarea>

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.event_desc"
            >{{ errors.event_desc[0] }}</p>
          </div>

          <div class="form-group">
            <label>Location</label>
            <input type="text" class="form-control" v-model="event.event_location">

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.event_location"
            >{{ errors.event_location[0] }}</p>
          </div>

          <div class="form-group">
            <label>Date & Time</label>
            <input
              type="text"
              id="datetime_edit"
              class="form-control datetimepicker"
              v-model="event.event_datetime"
            >

            <p
              class="text-danger"
              style="margin-top:5px"
              v-if="errors.event_datetime"
            >{{ errors.event_datetime[0] }}</p>
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
  props: ["openmodaledit"],
  data() {
    return {
      interests: {},
      event: {},
      errors: {},
      proceedBtn: "Proceed"
    };
  },
  watch: {
    openmodaledit() {
      if (this.openmodaledit) {
        this.$nextTick(() => {
          $(".select2").select2();
        });
      }
    }
  },
  mounted() {},
  methods: {
    close() {
      this.$emit("closeRequest");
      this.errors = {};
      if (this.anyError) this.$parent.user = this.temp;
    },
    update() {
      this.proceedBtn = "loading...";
      this.errors = {};
      this.event.interest_id = document.getElementById("interest_edit").value;
      this.event.event_datetime = document.getElementById(
        "datetime_edit"
      ).value;

      axios
        .patch(`/event/${this.event.event_id}`, this.event)
        .then(response => {
          this.proceedBtn = "Proceed";
          if (response.data.success) {
            $.gritter.add({
              title: "Success",
              text: response.data.msg,
              class_name: "color success"
            });

            $("#md-default").modal("toggle");
            this.$emit("reloadPage");
          } else {
            $.gritter.add({
              title: "Error",
              text: "Unknown Error!",
              class_name: "color danger"
            });
          }
        })
        .catch(error => {
          this.proceedBtn = "Proceed";
          if (!error.response.data.success && error.response.data.errors) {
            this.errors = error.response.data.errors;
          } else {
            $.gritter.add({
              title: "Error",
              text: "Internal Server Error!",
              class_name: "color danger"
            });
          }
        });
    }
  }
};
</script>