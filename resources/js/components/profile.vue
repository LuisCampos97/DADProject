<template>
   <div>
      <h1>Profile test</h1>
   </div>
</template>

<script>
module.exports = {
  name: "profile",
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
    profile() {
      this.showMessage = false;
    }
  }
};
</script>