<template>
    <div>
        <div class="alert" :class="typeofmsg" v-if="showMessage">             
            <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
            <strong>{{ message }}</strong>
        </div>
        <div class="container">
            <h2>Login</h2>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model.trim="user.email"
                    name="email" id="inputEmail"
                    placeholder="Enter email address"/>
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input
                    type="password" class="form-control" v-model="user.password"
                    name="password" id="inputPassword"
                    placeholder="Enter password"/>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="login">Login</a>
            </div>
        </div>
    </div>
</template>

<script>
module.exports = {
  name: "login",
  data() {
    return {
      user: {
        username: "",
        password: ""
      },
      typeofmsg: "alert-success",
      showMessage: false,
      message: "",
      loggedIn: false,
    };
  },
  methods: {
    login() {
      this.showMessage = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          //this.$store.commit("setToken", response.data.access_token);
          this.$router.push({name: 'dashboard'});
        })
        .then(response => {
          //this.$store.commit("setUser", response.data.data);
          this.typeofmsg = "alert-success";
          this.message = "User authenticated correctly";
          this.showMessage = true;
          Vue.set(this.$root, 'loggedIn', true);
        })
        .catch(error => {
          //this.$store.commit("clearUserAndToken");
          this.typeofmsg = "alert-danger";
          this.message = "Invalid credentials";
          this.showMessage = true;
        });
    }
  }
};
</script>