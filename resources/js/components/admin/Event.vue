<template>
  <div>
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>
    <div class="row" v-if="ready">
      <div class="col-md-4" v-for="(item, key) in events" :key="key">
        <div class="panel">
          <div class="panel-heading panel-heading-divider text-bold">
            {{ item.event_name }}
            <span class="panel-subtitle">
              <i class="mdi mdi-favorite-outline"></i>
              {{ item.interest.interest_name }}
              <i class="mdi mdi-card-giftcard"></i>
              {{ item.event_pts + 'PTS' }}
            </span>
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
              <button class="btn btn-sm btn-space btn-default" @click="edit(key)">Edit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="fab">+</div>

    <ModalEdit :openmodaledit="setSelect2" @closeRequest="closeModalEdit"></ModalEdit>
  </div>
</template>

<script>
let ModalEdit = require("./ModalEditEvent.vue");
export default {
  components: { ModalEdit },
  data() {
    return {
      events: {},
      interest: {},
      ready: false,
      errorLoading: false,
      setSelect2: false
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/event?service=index&page=1")
        .then(response => {
          this.ready = true;
          this.events = response.data.events;
          this.interest = response.data.interest;

          this.$children[0].interests = this.interest;
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
    edit(key) {
      this.setSelect2 = true;
      $("#md-default").modal("show");
      this.$children[0].event = this.events[key];
    },
    closeModalEdit() {
      this.setSelect2 = false;
      $("#md-default").modal("toggle");
    }
  }
};
</script>