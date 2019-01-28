<template>
  <div>
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>
    <div class="row" v-if="ready && !errorLoading">
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
    </div>
    <div class="fab" title="Search" @click="openSearchModal">
      <i class="mdi mdi-search"></i>
    </div>

    <ReadMore></ReadMore>
    <Ticket></Ticket>
    <Search @searchRequest="search"></Search>
  </div>
</template>

<script>
let ReadMore = require("./ReadMore.vue");
let Ticket = require("./Ticket.vue");
let Search = require("./Search.vue");
let eventDate;
let subsResult;

export default {
  components: { ReadMore, Ticket, Search },
  data() {
    return {
      events: {},
      interest: {},
      ready: false,
      errorLoading: false,
      setSelect2: false,
      now: new Date().setHours(0, 0, 0, 0),
      oneDay: 1000 * 60 * 60 * 24,
      btnJoin: "Join",
      q: ""
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/findevent?service=index")
        .then(response => {
          this.ready = true;
          this.events = response.data;
        })
        .catch(error => {
          this.errorLoading = true;
        });
    },
    search() {
      this.ready = this.errorLoading = false;
      axios
        .get("/findevent?q=" + this.q)
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
    readMore(key) {
      this.$children[0].event = this.events[key];
      $("#mod-primary").modal("show");
    },
    getEventStatus(date) {
      eventDate = new Date(date).setHours(0, 0, 0, 0);

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
      eventDate = new Date(date).setHours(0, 0, 0, 0);
      if (this.now <= eventDate) {
        return true;
      }
      return false;
    },
    join(key) {
      let event = this.events[key];
      this.btnJoin = "loading..";
      axios
        .post("/join", { event_id: event.event_id })
        .then(response => {
          this.btnJoin = "Join";
          this.$children[1].ticket = response.data.ticket;
          this.$children[1].msg = response.data.msg;
          $("#md-ticket").modal("show");
          this.events[key].going_count = 1;
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
    },
    openSearchModal() {
      $("#md-search").modal("show");
    }
  }
};
</script>