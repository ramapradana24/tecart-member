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
      <div class="col-sm-12">
        <div class="panel panel-default panel-table">
          <div class="panel-body">
            <table id="tb-participant" class="table table-hover table-fw-widget">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NIM</th>
                  <th>Name</th>
                  <th>Interest</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, key) in participants" :key="key">
                  <td>{{ key + 1 }}</td>
                  <td>{{ item.member.nim_member }}</td>
                  <td>{{ item.member.nama_member }}</td>
                  <td>{{ item.member.interest.interest_name }}</td>
                  <td>{{ (item.valid == 0) ? 'NOT VERIFIED' : 'VERIFIED' }}</td>
                  <td>
                    <button
                      v-if="item.valid == 1"
                      class="btn btn-sm btn-danger"
                      @click="unverified(key)"
                      :disabled="isLoading(key)"
                    >{{ (isLoading(key)) ? 'loading..' : 'UNVERIFIED' }}</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="fab" @click="verify">
      <i class="mdi mdi-assignment-check"></i>
    </div>

    <ModalVerify @updateGoing="update"></ModalVerify>
  </div>
</template>

<script>
let ModalVerify = require("./ModalVerify.vue");
export default {
  components: { ModalVerify },
  data() {
    return {
      ready: false,
      errorLoading: false,
      participants: {},
      id: this.$route.params.id,
      updateGoing: 0,
      loading: []
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/event-validation/" + this.id + "?s=1")
        .then(response => {
          this.ready = true;
          this.participants = response.data;
          this.$nextTick(() => {
            $.extend(true, $.fn.dataTable.defaults, {
              dom:
                "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
            });
            $("#tb-participant").dataTable();

            this.loading = this.participants.map(() => false);
          });
        })
        .catch(error => {
          this.errorLoading = true;
          console.log(error.response.data);
        });
    },
    verify() {
      $("#md-verify").modal("show");
    },
    update() {
      for (let i = 0; i < this.participants.length; i++) {
        if (this.participants[i].going_id == this.updateGoing) {
          this.participants[i].valid = 1;
        }
      }
    },
    unverified(key) {
      this.changeLoadingState(key);
      axios
        .patch("/event-validation/" + this.participants[key].going_id, {
          s: "unv"
        })
        .then(response => {
          this.changeLoadingState(key);
          if (response.data.success) {
            this.participants[key].valid = 0;
          }
        })
        .catch(error => {
          this.changeLoadingState(key);
        });
    },
    isLoading(key) {
      return this.loading[key];
    },
    changeLoadingState(key) {
      Vue.set(this.loading, key, !this.loading[key]);
    }
  }
};
</script>
