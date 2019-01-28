<template>
  <div id="md-ticket" tabindex="-1" role="dialog" style class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
            <span class="mdi mdi-close"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="text-success">
              <span class="modal-main-icon mdi mdi-check"></span>
            </div>
            <h3>Awesome!</h3>
            <p>Now you joined this event. Remember the date!
              <br>Your Ticket number is:
            </p>
            <h3 class="text-bold">{{ ticket }}</h3>
            <p>
              Show this ticket when you come to this event.
              <br>After this you can see this ticket on the
              <span class="text-bold">My Event</span> menu
            </p>
            <div class="xs-mt-50">
              <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Done</button>
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
      ticket: "",
      msg: ""
    };
  }
};
</script>
