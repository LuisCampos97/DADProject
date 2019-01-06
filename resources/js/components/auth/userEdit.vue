<template>
  <!-- template só pode ter um unico root element -->
  <div class="jumbotron" v-if="editingUser">
    <div class="row">
      <div class="row">
        <div class="col-md-2">
          <label>Old:</label>
        </div>
        <div class="col-md-2">
          <input type="text" v-model="pass.old_password" class="edit-input">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label>New:</label>
        </div>
        <div class="col-md-2">
          <input type="text" v-model="pass.new_password" class="edit-input">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label>RE:</label>
        </div>
        <div class="col-md-2">
          <input type="text" v-model="new_passwordRE" class="edit-input">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2" style="padding-left: 25%">
        <button
          class="profile-edit-btn"
          style="float: right"
          v-on:click.prevent="newPass()"
        >New Pass</button>
      </div>
      <div class="col-md-2">
        <button
          class="profile-edit-btn"
          style="float: right"
          v-on:click.prevent="saveUser()"
        >Save</button>
      </div>
      <div class="col-md-2">
        <button
          class="profile-edit-btn"
          style="float: right"
          v-on:click.prevent="cancelEdit()"
        >Cancel</button>
      </div>
      <div class="col-md-2">
        <button
          class="profile-edit-btn"
          style="float: right"
          v-on:click.prevent="submitFile()"
        >Submit photo</button>
        <!--TO DO: este botao é redundante, o botao Save é que vai chamar o método submitFile para alem do SaveUser -->
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  props: ["currentUser", "editingUser"],
  data: function() {
    return {
      pass: {
        old_password: "",
        new_password: "",
      },
      new_passwordRE: ""
    };
  },
  methods: {
    newPass: function() {
      console.log(this.new_passwordRE);
      if (this.new_passwordRE == this.pass.new_password) {
        axios.put("api/users/"+ this.$store.state.user.id +"/changePassword", this.pass).then(response => {
          if (response.data.error) {
            this.$emit("message", response.data.error, "danger");
          } else {
            this.$emit("message", response.data.msg, "success");
            this.$emit("user-saved", this.user);
          }
        });
      } else {
        this.$emit(
          "message",
          "New password and password confirmation do not match.",
          "danger"
        );
      }
    },
    cancelEdit: function() {
      this.$emit("cancel-edit");
    },
    saveUser: function() {
      this.$emit("save-user");
    },
    submitFile: function() {
      this.$emit("submit-file");
    }
  },
  mounted() {}
};
</script>
