<template>
  <!-- template só pode ter um unico root element -->
  <div class="jumbotron" v-if="editingUser">
    <h2>Edit User</h2>

    <div>
      <label>Name:</label>
      <input type="text" v-model="currentUser.name">
    </div>
    <div>
      <label>User name:</label>
      <input type="text" v-model="currentUser.username">
    </div>
    <button @click.prevent="cancelEdit()">Cancel</button>
    <button @click.prevent="saveUser()">Save</button>
    <button @click.prevent="submitFile()">Submit photo</button> <!--TO DO: este botao é redundante, o botao Save é que vai chamar o método submitFile para alem do SaveUser -->
  </div>
</template>
<script>
module.exports = {
  props: ["currentUser", "editingUser"],
  data: function() {
    return {};
  },
  methods: {
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