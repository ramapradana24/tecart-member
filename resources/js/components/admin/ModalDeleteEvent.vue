<template>
  <div
    id="md-del"
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
            <p>Are you sure you want to delete this Event?
              <br>
              '{{ event.event_name }}'
            </p>
            <div class="xs-mt-50">
              <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
              <button
                type="button"
                class="btn btn-space btn-warning"
                @click="del"
                :disabled="pcdBtn != 'Proceed'"
              >{{ pcdBtn }}</button>
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
      event: {},
      pcdBtn: "Proceed"
    };
  },
  methods: {
    del() {
      this.pcdBtn = "loading...";
      axios
        .delete(`/event/${this.event.event_id}`)
        .then(response => {
          if (response.data.success) {
            $.gritter.add({
              title: "Success",
              text: response.data.msg,
              class_name: "color success"
            });

            this.pcdBtn = "Proceed";
            this.$emit("reloadPage");
            this.close();
          } else {
            $.gritter.add({
              title: "Warning",
              text: "Unknown Error!",
              class_name: "color danger"
            });
          }
        })
        .catch(error => {
          $.gritter.add({
            title: "Warning",
            text: "Internal Server Error!",
            class_name: "color danger"
          });
        });
    },
    close() {
      $("#md-del").modal("toggle");
    }
  }
};
</script>