<template>
  <div id="md-search" tabindex="-1" role="dialog" style class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
            <span class="mdi mdi-close"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="search event" v-model="q">
            </div>
            <div class="col-sm-2" style="margin-top:2px;">
              <button @click="search" class="btn btn-lg btn-primary btn-block">
                <i class="mdi mdi-search"></i>
              </button>
            </div>
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
      q: ""
    };
  },
  methods: {
    search() {
      if (this.q == "") {
        this.q = "all";
      }
      this.$parent.q = this.q;
      this.$emit("searchRequest");
      $("#md-search").modal("toggle");
    }
  }
};
</script>
