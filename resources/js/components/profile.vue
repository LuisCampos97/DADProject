<template>
  <div class="jumbotron">
    <div class="container emp-profile">
      <div class="row">
        <div class="col-md-4">
          <div class="profile-img">
            <img :src="'/storage/profiles/' + user.photo_url">
            <div class="file btn btn-lg btn-primary">
              Change Photo
              <input type="file" id="file" ref="file" v-on:change="handleFileUpload()">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="profile-head">
            <h3>{{ user.name }}</h3>
            <h4>{{ user.type.charAt(0).toUpperCase() + user.type.slice(1) }}</h4>
            <ul class="nav nav-tabs"></ul>
          </div>
        </div>
        <div class="col-md-2">
          <input
            type="submit"
            class="profile-edit-btn"
            name="btnAddMore"
            value="Edit Profile"
            v-on:click.prevent="editUser(user)"
          >
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6">
              <label>User Id</label>
            </div>
            <div class="col-md-6">
              <p>{{ user.username }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Name</label>
            </div>
            <div class="col-md-6">
              <p>{{ user.name }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Email</label>
            </div>
            <div class="col-md-6">
              <p>{{ user.email }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div
      class="alert"
      :class="{'alert-success':showSuccess, 'alert-danger':showFailure}"
      v-if="showSuccess || showFailure"
    >
      <button type="button" class="close-btn" @click="showSuccess=false; showFailure=false;">&times;</button>
      <strong>{{(showSuccess)?successMessage:failMessage}}</strong>
    </div>

    <edit-user
      :current-user="currentUser"
      :editing-user="editingUser"
      @cancel-edit="cancelEdit"
      @save-user="saveUser"
      @submit-file="submitFile"
    ></edit-user>
  </div>
</template>

<script>
module.exports = {
  name: "profile",
  data() {
    return {
      user: this.$store.state.user,
      typeofmsg: "alert-success",
      showMessage: false,
      message: "",
      loggedIn: false,
      file: "",
      editingUser: false,
      currentUser: {},
      successMessage: "",
      failMessage: "",
      showSuccess: false,
      showFailure: false
    };
  },
  methods: {
    profiles: function() {
      this.showMessage = false;
    },
    submitFile: function() {
      //Submete a foto para o servidor
      let formData = new FormData(); //inicializa os dados do form
      formData.append("file", this.file); //adiciona os dados do form que vamos submeter
      const user = this.currentUser;

      axios
        .post(
          "/api/users/" + user.id, //fazemos um request para submeter (POST) no URL profile/photo
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          }
        )
        .then(function() {
          this.showSuccess = true;
          this.showFailure = false;
          this.successMessage = "Profile photo changed!";
          this.editingUser = false;
          setTimeout(() => {
            this.showFailure = false;
            this.showSuccess = false;
          }, 2000);
        })
        .catch(function() {
          this.showFailure = true;
          this.showSuccess = false;
          this.failMessage = error.response.data.message;
          console.dir(error);
        });
    },
    handleFileUpload: function() {
      //lida com mudanças no upload da foto
      this.file = this.$refs.file.files[0];
    },
    editUser: function(user) {
      this.editingUser = true;
      this.currentUser = Object.assign({}, user);
    },
    cancelEdit: function() {
      this.editingUser = false;
    },
    saveUser: function() {
      const user = this.currentUser;
      axios
        .put("/api/users/" + user.id, user)
        .then(response => {
          this.showSuccess = true;
          this.showFailure = false;
          this.successMessage = "User updated";

          Vue.set(this.user, response.data.data);
          this.editingUser = false;
          this.$store.commit("setUser", response.data.data);  //TO DO: atualizar o user, para que depois de fazer save seja visto
                                                              // o novo username e name (pq agora só atualiza se fizermos F5)
          setTimeout(() => {
            this.showFailure = false;
            this.showSuccess = false;
          }, 2000);
        })
        .catch(error => {
          this.showFailure = true;
          this.showSuccess = false;
          this.failMessage = error.response.data.message;
          console.dir(error);
        });
    }
  }
};
</script>

<style>
body {
  background: rgb(75, 75, 75);
}

.jumbotron {
  padding: 3%;
  margin-top: 3%;
  margin-bottom: 3%;
  border-radius: 0.5rem;
  background: #fff;
}

.profile-img {
  text-align: center;
}

.profile-img img {
  width: 70%;
  height: 100%;
}

.profile-img .file {
  position: relative;
  overflow: hidden;
  margin-top: -20%;
  width: 70%;
  border: none;
  border-radius: 0;
  font-size: 15px;
  background: #212529b8;
}

.profile-img .file input {
  position: absolute;
  opacity: 0;
  right: 0;
  top: 0;
}

.profile-head h3 {
  color: #333;
}

.profile-head h4 {
  color: #0062cc;
}

.profile-img:hover .btn-lg {
  opacity: 1;
}

.btn-lg {
  opacity: 0;
}

.profile-edit-btn {
  border: none;
  border-radius: 1.5rem;
  width: 70%;
  padding: 2%;
  font-weight: 600;
  color: #6c757d;
  cursor: pointer;
}

.profile-head .nav-tabs {
  margin-bottom: 5%;
}

.profile-head .nav-tabs .nav-link {
  font-weight: 600;
  border: none;
}

.profile-head .nav-tabs .nav-link.active {
  border: none;
  border-bottom: 2px solid #0062cc;
}

.profile-work {
  padding: 14%;
  margin-top: -15%;
}

.profile-work p {
  font-size: 12px;
  color: #818182;
  font-weight: 600;
  margin-top: 10%;
}

.profile-work a {
  text-decoration: none;
  color: #495057;
  font-weight: 600;
  font-size: 14px;
}

.profile-work ul {
  list-style: none;
}

.profile-tab label {
  font-weight: 600;
}

.profile-tab p {
  font-weight: 600;
  color: #0062cc;
}
</style>
