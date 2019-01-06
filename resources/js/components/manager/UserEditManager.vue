<template>
  <div class="container" style="padding: 25px;" v-if="user && editingUser">
    <h2>Edit User</h2>
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input
        type="email"
        class="form-control"
        v-model.trim="user.email"
        name="email"
        id="inputEmail"
        placeholder="Enter email address"
      >
      <p class="help-block" v-for="error in errors.email" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputUsername">Username</label>
      <input
        type="text"
        class="form-control"
        v-model="user.username"
        name="username"
        id="inputUsername"
        placeholder="Enter username"
      >
      <p class="help-block" v-for="error in errors.username" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input
        type="text"
        class="form-control"
        v-model="user.name"
        name="name"
        id="inputName"
        placeholder="Enter full name"
      >
      <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputType">Type</label>
      <select class="form-control" name="inputType" v-model="user.type">
        <option disabled value>-- Please select one --</option>
        <option v-for="option in options" v-bind:key="option.key">{{ option.value }}</option>
      </select>
      <p class="help-block" v-for="error in errors.type" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <a class="btn btn-success" v-on:click.prevent="editUser()">Save</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelEdit()">Cancel</a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user", "editingUser"],
  data() {
    return {
      errors: {
        email: [],
        username: [],
        name: [],
        type: []
      },
      options: [
        { value: "Manager", key: "manager" },
        { value: "Waiter", key: "waiter" },
        { value: "Cook", key: "cook" },
        { value: "Cashier", key: "cashier" }
      ]
    };
  },
  methods: {
    cancelEdit() {
      this.$emit("cancel-edit");
    },
    editUser() {
      axios
        .put("api/users/" + user.id, user)
        .then(response => {
          Object.assign(this.user, response.data.data);
          this.$emit("edit-user");
        })
        .catch(error => {
          let data = error.response.data.errors;

          for (let key in this.errors) {
            this.errors[key] = [];

            let errorMessage = data[key];

            if (errorMessage) {
              this.errors[key] = errorMessage;
            }
          }
        });
    }
  }
};
</script>

<style>
.profile-img {
  text-align: center;
}

.profile-img img {
  width: 30%;
  height: 40%;
}

.profile-img .file {
  position: relative;
  overflow: hidden;
  margin-top: -20%;
  width: 70%;
  border: none;
  border-radius: 0;
  font-size: 12px;
  background: #212529b8;
}

.profile-img .file input {
  position: absolute;
  opacity: 0;
  right: 0;
  top: 0;
}

.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>
