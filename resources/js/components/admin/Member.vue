<template>
  <div>
    <div class="text-center" v-if="!ready && !errorLoading">
      <img src="/ripple.svg" alt>
    </div>
    <div class="text-center" v-if="errorLoading">
      <img src="/error.svg" height="100px">
      <h3>Oh no! Something wrong with our server. Try to refresh the page.</h3>
    </div>

    <div id="accordion1" class="panel-group accordion" v-if="ready">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a
              data-toggle="collapse"
              data-parent="#accordion1"
              href="#summary"
              aria-expanded="false"
              class="collapsed"
            >
              <i class="icon mdi mdi-chevron-down"></i>Summary
            </a>
          </h4>
        </div>
        <div id="summary" class="panel-collapse collapse" aria-expanded="false">
          <div class="panel-body">
            <div class="row user-progress" v-for="(item, key) in otherMemberCount" :key="key">
              <div class="col-md-10">
                <span class="title">{{ item.interest_name + '('+ item.member_count +')' }}</span>
                <div class="progress">
                  <div
                    :style="progressInterestCount(allMembersCount, item.member_count)"
                    class="progress-bar progress-bar-primary"
                  ></div>
                </div>
              </div>
              <div class="col-md-2">
                <span
                  class="value"
                >{{ (item.member_count == 0) ? '0%' : Math.round((item.member_count/allMembersCount) * 100, -1) + "%" }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" v-if="ready">
      <div class="col-sm-12">
        <div class="panel panel-default panel-table">
          <div class="panel-body">
            <table id="table1" class="table table-hover table-fw-widget">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NIM</th>
                  <th>Name</th>
                  <th>ID LINE</th>
                  <th>Interest</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, key) in members" :key="key">
                  <td>{{ key + 1 }}</td>
                  <td>{{ item.nim_member }}</td>
                  <td>{{ item.nama_member }}</td>
                  <td>{{ item.id_line }}</td>
                  <td>{{ item.interest.interest_name }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- <ModalEdit :openmodaledit="setSelect2" @closeRequest="closeModalEdit"></ModalEdit> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      members: {},
      allMembersCount: 0,
      otherMemberCount: {},
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
        .get("/member?service=index")
        .then(response => {
          this.members = response.data.members;
          this.allMembersCount = response.data.all_users;
          this.otherMemberCount = response.data.interest_counts;
          this.ready = true;

          this.$nextTick(() => {
            $.extend(true, $.fn.dataTable.defaults, {
              dom:
                "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
            });

            $("#table1").dataTable();
          });
        })
        .catch(error => {
          this.errorLoading = true;
        });
    },
    progressInterestCount(all, count) {
      return "width:" + Math.round((count / all) * 100) + "%";
    }
  }
};
</script>