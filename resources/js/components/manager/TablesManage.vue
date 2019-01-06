<template>
  <div class="container" style="padding: 25px;">
    <h3>Restaurant Tables Manage</h3>
    <a class="btn btn btn-info" v-on:click.prevent="addRestaurantTables()">
      <i class="fas fa-plus"></i> Add Table
    </a>
    <div class="row">
      <div class="card-deck">
        <div
          v-for="table in tables"
          :key="table.table_number"
          class="col-lg-3 d-flex align-items-stretch"
        >
          <div class="card bg-light mt-3">
            <div class="card-body">
              <h4 class="card-title">Table {{ table.table_number }}</h4>
              <a class="btn btn btn-danger" v-on:click.prevent="deleteTable(table)">
                <i class="fas fa-trash"></i>
              </a>
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
      tables: {}
    };
  },
  methods: {
    getTables() {
      axios.get("/api/restaurantTables").then(response => {
        this.tables = response.data.data;
      });
    },
    deleteTable(table) {
      axios
        .delete("/api/restaurantTables/" + table.table_number)
        .then(response => {
          this.getTables();
        });
    },
    addRestaurantTables() {
      axios.post("/api/restaurantTables/register").then(response => {
        this.getTables();
      })
    },
  },
  mounted() {
    this.getTables();
  }
};
</script>
