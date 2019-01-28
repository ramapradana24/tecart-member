<template>
  <div
    id="md-abandon"
    tabindex="-1"
    data-keyboard="false"
    data-backdrop="static"
    role="dialog"
    class="modal fade"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" aria-hidden="true" class="close">
            <span class="mdi mdi-close"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="text-warning">
              <span class="modal-main-icon mdi mdi-alert-triangle"></span>
            </div>
            <h3>Warning!</h3>
            <p>Are you sure you want to leave this Event?
              <br>
              '{{ event.event_name }}'
            </p>
            <div class="xs-mt-50">
              <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
              <button
                type="button"
                class="btn btn-space btn-danger"
                @click="abandon"
                :disabled="okBtn != 'Abandon'"
              >{{ okBtn }}</button>
            </div>
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
      okBtn: "Abandon",
      event: {}
    };
  },
  methods: {
    abandon() {
      this.okBtn = "loading...";
      axios
        .delete("/myevent/" + this.event.going_id)
        .then(response => {
          this.okBtn = "Abandon";
          $("#md-abandon").modal("toggle");
          $.gritter.add({
            title: "Success",
            text: response.data.msg,
            class_name: "color success"
          });
          this.$emit("reload");
        })
        .catch(error => {
          this.okBtn = "Abandon";
          if (error.response.data.msg) {
            $.gritter.add({
              title: "Error",
              text: error.response.data.msg,
              class_name: "color danger"
            });
          } else {
            $.gritter.add({
              title: "Error",
              text: "Internal server error!",
              class_name: "color danger"
            });
          }
        });
    }
  }
};
</script>