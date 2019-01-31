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
            <table id="tb-event" class="table table-hover table-fw-widget">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Event Name</th>
                  <th>Participant</th>
                  <th>Interest</th>
                  <th>Location</th>
                  <th>Datetime</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, key) in events" :key="key">
                  <td>{{ key + 1 }}</td>
                  <td>{{ item.event_name }}</td>
                  <td>{{ item.going_count }}</td>
                  <td>{{ item.interest.interest_name }}</td>
                  <td>{{ item.event_location }}</td>
                  <td>{{ convertDate(item.event_datetime) }}</td>
                  <td>
                    <router-link
                      :to="{name:'detail', params:{id: item.event_id}}"
                      class="btn btn-default btn-sm"
                    >validate</router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ready: false,
      errorLoading: false,
      events: {}
    };
  },
  mounted() {
    this.load();
  },
  methods: {
    load() {
      this.ready = this.errorLoading = false;
      axios
        .get("/event-validation?s=1")
        .then(response => {
          this.ready = true;
          this.events = response.data;

          this.$nextTick(() => {
            $.extend(true, $.fn.dataTable.defaults, {
              dom:
                "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
                "<'row be-datatable-body'<'col-sm-12'tr>>" +
                "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
            });

            $("#tb-event").dataTable();
          });
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
    }
  }
};
</script>

