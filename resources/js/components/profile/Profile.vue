<template>
  <div class="main-content container-fluid">
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>

    <div class="user-profile" v-if="ready">
      <div class="row">
        <div class="col-md-5">
          <div class="user-display">
            <div class="user-display-bg">
              <img src="assets/img/user-profile-display.png" alt="Profile Background">
            </div>
            <div class="user-display-bottom">
              <div class="user-display-avatar">
                <img src="assets/img/avatar-150.png" alt="Avatar">
              </div>
              <div class="user-display-info">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="name">{{ user.nama_member }}</div>
                    <div class="nick">@{{ user.username }}</div>
                  </div>
                  <div class="col-sm-4">
                    <div
                      class="title"
                      style="text-transform:uppercase; font-size:10px"
                    >tecart points</div>
                    <div class="counter" style="font-weight:bold">{{ pts }}</div>

                    <button
                      class="btn btn-rounded btn-space btn-default"
                      style="margin-top:20px; float:right"
                      @click="openModalEdit"
                    >
                      <i class="icon icon-left mdi mdi-edit"></i> Edit Profile
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="user-info-list panel panel-default">
            <div class="panel-heading panel-heading-divider">
              About Me
              <span
                class="panel-subtitle"
              >Owning our story and loving ourselves through that process is the bravest thing we’ll ever do.</span>
            </div>
            <div class="panel-body">
              <table class="no-border no-strip skills">
                <tbody class="no-border-x no-border-y">
                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-book"></span>
                    </td>
                    <td class="item">
                      Event Attendance
                      <span class="icon s7-portfolio"></span>
                    </td>
                    <td>{{ (countGoing > 1 || countGoing == 0) ? countGoing + ' times' : countGoing + ' time' }}</td>
                  </tr>

                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-account-box"></span>
                    </td>
                    <td class="item">
                      NIM
                      <span class="icon s7-portfolio"></span>
                    </td>
                    <td>{{ user.nim_member }}</td>
                  </tr>

                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-email"></span>
                    </td>
                    <td class="item">
                      Email
                      <span class="icon s7-portfolio"></span>
                    </td>
                    <td>{{ user.email }}</td>
                  </tr>

                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-accounts-list"></span>
                    </td>
                    <td class="item">
                      LINE ID
                      <span class="icon s7-gift"></span>
                    </td>
                    <td>{{ user.id_line }}</td>
                  </tr>
                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-male-female"></span>
                    </td>
                    <td class="item">
                      Gender
                      <span class="icon s7-phone"></span>
                    </td>
                    <td>{{ (user.jk_member == 1) ? "Male" : 'Female' }}</td>
                  </tr>
                  <tr>
                    <td class="icon">
                      <span class="mdi mdi-favorite"></span>
                    </td>
                    <td class="item">
                      Interest
                      <span class="icon s7-map-marker"></span>
                    </td>
                    <td>{{ user.interest.interest_name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="panel panel-default">
            <div class="panel-heading panel-heading-divider">
              Latest Activity
              <span class="panel-subtitle">Do a new thing in a new way. Do it always!</span>
            </div>
            <div class="panel-body">
              <ul class="user-timeline" v-if="going.length > 0">
                <li class :class="{ 'latest' : key == 0 }" v-for="(item, key) in going" :key="key">
                  <div class="user-timeline-date">{{ convertDate(item.event.event_datetime) }}</div>
                  <div class="user-timeline-title">{{ item.event.event_name }}</div>
                  <div class="user-timeline-description">{{ item.event.event_desc }}</div>
                </li>
              </ul>
              <div class="text-center" style="margin-top:25px;" v-if="going.length <= 0">
                <img src="complaint.png" alt width="80">
                <h4>Oops! It looks like you haven't participated in any event or workshop.</h4>
                <h4>You better come along to improve your skills.</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <EditProfile :openmodal="setSelect2" @closeRequest="closeModalUpdate"></EditProfile>
  </div>
</template>

<script>
let EditProfile = require("./EditProfile.vue");
export default {
  components: { EditProfile },
  data() {
    return {
      user: {},
      going: {},
      interests: {},
      countGoing: 0,
      pts: 0,
      ready: false,
      errorLoading: false,
      setSelect2: false
    };
  },
  mounted() {
    this.ready = false;
    axios
      .get("/profile?service=index")
      .then(response => {
        this.user = response.data.user;
        this.going = response.data.going;
        this.interests = response.data.interests;
        this.countGoing = response.data.count_going;
        this.pts = response.data.pts;

        this.$children[0].userProfile = this.user;
        this.$children[0].temp = response.data.user;

        this.$children[0].interests = this.interests;
        this.ready = true;
      })
      .catch(error => {
        this.errorLoading = true;
      });
  },
  methods: {
    convertDate(date) {
      return moment(date).format("MMMM Do YYYY h:mm a");
    },
    convertTime(time) {
      return moment(time, "HH:mm:ss").format("h:mm a");
    },
    openModalEdit() {
      this.setSelect2 = true;
      this.$children[0].userProfile = this.user;
      this.$children[0].temp = JSON.parse(JSON.stringify(this.user));
      $("#md-default").modal("show");
    },
    closeModalUpdate() {
      this.setSelect2 = false;
      $("#md-default").modal("toggle");
    }
  }
};
</script>
