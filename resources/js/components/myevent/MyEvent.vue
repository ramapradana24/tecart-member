<template>
  <div>
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>
    <div class="text-center" v-if="!errorLoading && ready && events.length == 0">
      <img src="/complaint.png" height="100px">
      <h3>You have not join any event yet!</h3>
    </div>

    <div class="row" v-if="ready && !errorLoading && events">
      <div class="col-md-4" v-for="(item, key) in events" :key="key">
        <div class="panel">
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
            <p class="p-limit">{{ item.event_desc }}</p>
            <span>Loc & Date:</span>
            <p>
              <i class="mdi mdi-pin"></i>
              {{ item.event_location }}
              <br>
              <i class="mdi mdi-time"></i>
              {{ convertDate(item.event_datetime)}}
            </p>

            <div class="pull-right">
              <button class="btn btn-sm btn-space btn-default" @click="ticket(key)">Ticket</button>
              <button
                v-if="item.valid == 0"
                class="btn btn-sm btn-space btn-danger"
                @click="abandon(key)"
              >Abandon</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Ticket></Ticket>
    <Abandon @reload="load"></Abandon>
  </div>
</template>

<script>
let subsResult;
let Ticket = require("./Ticket.vue");
let Abandon = require("./Abandon.vue");

export default {
  components: { Ticket, Abandon },
  data() {
    return {
      ready: false,
      errorLoading: false,
      events: {},
      now: new Date().setHours(0, 0, 0, 0),
      oneDay: 1000 * 60 * 60 * 24
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    ticket(key) {
      this.$children[0].item = this.events[key];
      $("#md-ticket").modal("show");
    },
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/myevent?s=i")
        .then(response => {
          this.ready = true;
          this.events = response.data;
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
    abandon(key) {
      this.$children[1].event = this.events[key];
      $("#md-abandon").modal("show");
    }
  }
};
</script>