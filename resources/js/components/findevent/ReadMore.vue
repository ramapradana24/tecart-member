<template>
  <div id="mod-primary" tabindex="-1" role="dialog" class="modal fade" v-if="event">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="text-bold">{{ event.event_name }}</h4>
          <br>
          <span class="text-uppercase text-muted fnt-12">description</span>
          <p>{{ event.event_desc }}</p>

          <span class="text-uppercase text-muted fnt-12">interest</span>
          <p>{{ event.interest.interest_name }}</p>
          <span class="text-uppercase text-muted fnt-12">points</span>
          <p>{{ event.event_pts }}</p>

          <span class="text-uppercase text-muted fnt-12">Location</span>
          <p>{{ event.event_location }}</p>

          <span class="text-uppercase text-muted fnt-12">Date & Time</span>
          <p>{{ convertDate(event.event_datetime)}}</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-sm btn-space btn-default" data-dismiss="modal">close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      event: {
        event_name: "",
        event_desc: "",
        interest: {
          interest_name: ""
        },
        event_location: "",
        event_datetime: ""
      }
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