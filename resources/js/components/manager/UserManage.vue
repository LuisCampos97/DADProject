<template>
  <div class="jumbotron" v-if="currentUser.type == 'manager'">
    <div class="alert alert-success" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>
    <h3>Menu Users</h3>
    
    <input style="width: 100%" type="text" id="searchInput" @keypress.enter="search" placeholder="Search for users...">

    <div class="table-responsive">
    <table id="userTable" class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th>Fullname</th>
          <th>Username</th>
          <th>E-mail</th>
          <th>Photo</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="user in users" :key="user.id">
        <tr>
          <td>{{ user.name }}</td>
          <td>{{ user.username }}</td>
          <td>{{ user.email }}</td>
          <img class="rounded mx-auto d-block" :src="'/storage/profiles/' + user.photo_url" alt="Thumbnail [100px180]" data-holder-rendered="true">
          <td>
            <a class="btn btn-sm btn-info" v-on:click.prevent="updateUser(user)"><i class="fas fa-edit"></i> Edit</a>
            <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)"><i class="fas fa-trash"></i> Delete</a>
          </td>
        </tr>
      </tbody>
    </table>

    <!--______________________TODO______________________-->

    <modal name="modal-update" :width="600" :height="500">
      <div class="container" style="padding: 25px;">
        <h2>{{ currentItem.name }}</h2>
        <div class="form-group">
          <label for="inputName">Name</label>
          <input
            type="text"
            class="form-control"
            v-model="currentItem.name"
            name="name"
            id="inputName"
            placeholder="Name"
          >
          <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
        </div>
        <div class="form-group">
          <label for="inputType">Type</label>
          <select class="form-control" name="inputType" v-model="currentItem.type">
            <option
              v-for="option in options"
              v-bind:key="option.key"
              :selected="option.key == currentItem.type"
            >{{ option.key }}</option>
          </select>
          <p class="help-block" v-for="error in errors.type" v-bind:key="error">{{ error }}</p>
        </div>
        <div class="form-group">
          <label for="inputDescription">Description</label>
          <input
            type="text"
            class="form-control"
            v-model="currentItem.description"
            name="description"
            id="inputDescription"
            placeholder="Description"
          >
          <p class="help-block" v-for="error in errors.description" v-bind:key="error">{{ error }}</p>
        </div>
        <!-- <div class="form-group">
          <label for="inputPhoto">Photo</label>
          <input
            type="file"
            class="form-control"
            ref="file"
            name="photo"
            id="inputPhoto"
          >
          <p class="help-block" v-for="error in errors.photo" v-bind:key="error">{{ error }}</p>
        </div>-->
        <div class="form-group">
          <label for="inputPrice">Price</label>
          <input
            type="number"
            class="form-control"
            v-model="currentItem.price"
            name="price"
            id="inputPrice"
            placeholder="Price"
          >
          <p class="help-block" v-for="error in errors.price" v-bind:key="error">{{ error }}</p>
        </div>

        <div class="form-group">
          <a class="btn btn-success" v-on:click.prevent="updateItem(currentItem)">Save</a>
          <a class="btn btn-danger" v-on:click.prevent="cancelUpdate()">Cancel</a>
        </div>
      </div>
    </modal>

    </div>
  </div>
</template>

<script>
import { Vuetable, VuetablePagination } from "vuetable-2";
export default {
  components: {
    Vuetable,
    VuetablePagination
  },
  props: ["currentUser"],
  data() {
    return {
      users: [],
      showMessage: false,
      message: ""
    };
  },
  methods: {
    getUsers() {
      axios.get("/api/users").then(response => {
        this.users = response.data.data;
      });
    },
    updateUser(user) {
        this.currentUser = user;
        this.$modal.show("modal-update");
    },
    deleteUser(user) {
      axios.delete("api/users/" + user.id).then(response => {
        this.showMessage = true;
        this.message = `Users "${user.name}" deleted`;
        this.getUsers();
      });
    },
    search: function(){
        // Declare variables 
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("userTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            } 
        }
    }
  },
  mounted() {
    this.getUsers();
  }
};
</script>

<style scoped>
.searchInput:before {
  font-family: 'FontAwesome'; /* Add a search icon to input */
  top: 0;
  left: 10px;
  content: "\f005";
}

</style>
