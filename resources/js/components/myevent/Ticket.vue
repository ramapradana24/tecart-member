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
            <h1 class="text-bold">{{ (item.valid == 1) ? 'VERIFIED' : item.ticket }}</h1>
            <h2>{{ item.event_name }}</h2>
            <p
              class="text-uppercase"
            >{{ item.event_location + ', ' + convertDate(item.event_datetime) }}</p>
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
      item: {}
    };
  },
  methods: {
    convertDate(date) {
      if (date == "" || date == null) {
        return "";
      }
      return moment(date).format("MMMM Do YYYY h:mm a");
    }
  }
};
</script>