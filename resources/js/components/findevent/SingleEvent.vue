<template>
  <div>
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>
    <div class="text-center" v-if="!errorLoading && ready && !item">
      <img src="/complaint.png" height="100px">
      <h3>Event that you are looking for is not found!</h3>
    </div>

    <div class="row text-center" v-if="ready && !errorLoading && item">
      <div class="panel col-md-6 col-sm-12" style="display:block;margin:0 auto;">
        <div class="panel-heading panel-heading-divider text-bold">
          {{ item.event_name }}
          <p class="panel-subtitle">
            <span class="label label-warning" style="margin-left:2px;">
              <i class="mdi mdi-favorite-outline"></i>
              {{ item.interest.interest_name }}
            </span>
            
            <span class="label label-success" style="margin-left:2px;">
              <i class="mdi mdi-card-giftcard"></i>
              {{ item.event_pts + 'PTS' }}
            </span>
            <span
              class="label label-primary"
              style="margin-left:2px;"
            >{{ getEventStatus(item.event_datetime) }}</span>
          </p>
        </div>
        <div class="panel-body">
          <span>Decription:</span>
          <p>{{ item.event_desc }}</p>
          <span>Loc & Date:</span>
          <p>
            <i class="mdi mdi-pin"></i>
            {{ item.event_location }}
            <br>
            <i class="mdi mdi-time"></i>
            {{ convertDate(item.event_datetime)}}
          </p>

          <div class="pull-right">
            <button class="btn btn-sm btn-space btn-default" @click="readMore(key)">Read More</button>
            <button
              v-if="displayJoinButton(item.event_datetime) || item.going_count > 0"
              class="btn btn-sm btn-space"
              @click="join(key)"
              :class="{
                    'btn-primary' : item.going_count == 0,
                    'btn-success' : item.going_count > 0
                    }"
              :disabled="item.going_count > 0 || btnJoin != 'Join'"
            >{{ (item.going_count > 0) ? 'Joined' : btnJoin }}</button>
          </div>
        </div>
      </div>
    </div>
    <Ticket></Ticket>
  </div>
</template>

<script>
let Ticket = require("./Ticket.vue");
let subsResult;
export default {
  components: { Ticket },
  data() {
    return {
      id: this.$route.params.id,
      item: {},
      ready: false,
      errorLoading: false,
      now: new Date().setHours(0, 0, 0, 0),
      oneDay: 1000 * 60 * 60 * 24,
      btnJoin: "Join"
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/findevent/" + this.id + "?f=1")
        .then(response => {
          this.ready = true;
          this.item = response.data;
        })
        .catch(error => {
          this.errorLoading = true;
        });
    },
    convertDate(date) {
      if (date == "" || date == null) {
        return "";
      }
      return moment(date).format("MMMM Do YYYY h:mm a");
    },
    getEventStatus(date) {
      let eventDate = new Date(date).setHours(0, 0, 0, 0);

      if (this.now <= eventDate) {
        subsResult = Math.round((eventDate - this.now) / this.oneDay);
        if (subsResult == 1) {
          return "its tomorrow";
        } else if (subsResult == 0) {
          return "its today";
        }

        return subsResult + " days to go";
      }
    },
    displayJoinButton(date) {
      let eventDate = new Date(date).setHours(0, 0, 0, 0);
      if (this.now <= eventDate) {
        return true;
      }
      return false;
    },
    join(key) {
      let event = this.item;
      this.btnJoin = "loading..";
      axios
        .post("/join", { event_id: event.event_id })
        .then(response => {
          this.btnJoin = "Join";
          this.$children[0].ticket = response.data.ticket;
          this.$children[0].msg = response.data.msg;
          $("#md-ticket").modal("show");
          this.item.going_count = 1;
        })
        .catch(error => {
          this.btnJoin = "Join";
          if (!error.response.data.success && error.response.data.msg) {
            $.gritter.add({
              title: "Error",
              text: error.response.data.msg,
              class_name: "color danger"
            });
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