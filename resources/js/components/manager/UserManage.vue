<template>
  <div class="jumbotron">
    <div class="alert alert-success" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>
    <h3>Menu Users</h3>

    <input
      style="width: 100%"
      type="text"
      id="searchInput"
      @keypress.enter="search"
      placeholder="Search for users..."
    >

    <div class="table-responsive">
      <table id="userTable" class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Photo</th>
            <th>Fullname</th>
            <th>Username</th>
            <th>E-mail</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody v-for="user in users.data" :key="user.id">
          <tr>
            <img
              class="rounded mx-auto d-block"
              :src="'/storage/profiles/' + user.photo_url"
              alt="No photo"
              data-holder-rendered="true"
            >
            <td>{{ user.name }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>
              <a class="btn btn-info" v-on:click.prevent="openUserEditComponent(user)">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a class="btn btn-danger" v-on:click.prevent="deleteUser(user)">
                <i class="fas fa-trash"></i> Delete
              </a>
              <a
                class="btn btn-danger"
                v-on:click.prevent="updateBlock(user)"
                v-if="user.blocked == 0"
              >
                <i class="fas fa-lock"></i> Block
              </a>
              <a
                class="btn btn-success"
                v-on:click.prevent="updateBlock(user)"
                v-if="user.blocked == 1"
              >
                <i class="fas fa-lock-open"></i> Unblock
              </a>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <pagination :data="users" @pagination-change-page="getUsers"></pagination>
      </div>
      <user-editManager
        :user="currentUser"
        :editingUser="editingUser"
        v-on:cancel-edit="closeUserEditComponent()"
        v-on:edit-user="closeUserEditComponent()"
      ></user-editManager>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: {},
      showMessage: false,
      message: "",
      currentUser: {},
      editingUser: false
    };
  },
  methods: {
    getUsers(page = 1) {
      axios.get("/api/users?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    deleteUser(user) {
      axios.delete("api/users/" + user.id).then(response => {
        this.showMessage = true;
        this.message = `User "${user.name}" deleted`;
        this.getUsers();
      });
    },
    openUserEditComponent(user) {
      this.currentUser = user;
      this.editingUser = true;
    },
    closeUserEditComponent() {
      this.getUsers();
      this.editingUser = false;
    },
    search: function() {
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
    },
    updateBlock(user) {
      axios.put("/api/users/" + user.id + "/editBlock").then(response => {
        Object.assign(this.user, response.data.data);
        this.getUsers();
      });
    }
  },
  mounted() {
    this.getUsers();
  }
};
</script>

<style scoped>
.searchInput:before {
  font-family: "FontAwesome"; /* Add a search icon to input */
  top: 0;
  left: 10px;
  content: "\f005";
}
</style>

<style scoped>
.pagination {
  justify-content: center !important;
}
</style>
