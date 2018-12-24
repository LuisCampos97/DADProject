<template>
  <div class="jumbotron">
    <div class="container emp-profile">
      <div class="row">
        <div class="col-md-4">
          <div class="profile-img">
            <img :src="'/storage/profiles/' + user.photo_url">
            <div class="file btn btn-lg btn-primary">
              Change Photo
              <input type="file" id="file" ref="file" v-on:change.prevent="handleFileUpload()">
            </div>
          </div>
          <div class="row">
            <div class="profile-shift">
              <p>Shift</p>
              <a>Start: {{ user.last_shift_start }}</a>
              <br>
              <a v-if="user.shift_active == '0'">End: {{ user.last_shift_end }}</a>
              <br>
              <a v-if="user.shift_active == '0'">Time: {{ timePassed }}</a>
              <br>
              <button
                v-if="user.shift_active == '0'"
                class="profile-shift-btn"
                v-on:click.prevent="invertShift()"
              >Start</button>
              <button
                v-if="user.shift_active == '1'"
                class="profile-shift-btn"
                v-on:click.prevent="invertShift()"
              >Quit</button>
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
        <div class="col-md-8 profile-info">
          <div class="row">
            <div class="col-md-6">
              <label>User Id</label>
            </div>
            <div class="col-md-6">
              <p class="edit-label">{{ user.username }}</p>
              <input type="text" v-model="user.username" class="edit-input" style="display:none">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Name</label>
            </div>
            <div class="col-md-6">
              <p class="edit-label">{{ user.name }}</p>
              <input type="text" v-model="user.name" class="edit-input" style="display:none">
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
      <button type="button" class="close-btn" v-on:click.prevent="showSuccess=false; showFailure=false;">&times;</button>
      <strong>{{(showSuccess)?successMessage:failMessage}}</strong>
    </div>

    <edit-user
      :current-user="currentUser"
      :editing-user="editingUser"
      v-on:cancel-edit="cancelEdit"
      v-on:save-user="saveUser"
      v-on:submit-file="submitFile"
    ></edit-user>
  </div>
</template>

<script>
module.exports = {
  data: function() {
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
  computed: {
    timePassed() {
      var diff = new Date() - new Date(this.$store.state.user.last_shift_end);
      console.log(diff);
      var days = Math.floor(diff / 1000 / 60 / 60 / 24);
      var hours = Math.floor(diff / 1000 / 60 / 60);
      var minutes = Math.floor(diff / 1000 / 60) - hours * 60;
      if (days == 0 && hours == 0) {
        return minutes + " m";
      } else if (days == 0) {
        return hours + " h : " + minutes + " m";
      } else {
        return days + " d : " + hours + " h : " + minutes + " m";
      }
    }
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
      $(".edit-label").hide();
      $(".edit-input").show();
      this.editingUser = true;
      this.currentUser = Object.assign({}, user);
    },
    invertShift: function() {
      const user = this.$store.state.user;
      axios
        .put("/api/users/" + user.id + "/shift", user)
        .then(response => {
          Vue.set(this.user, response.data.data);
          this.$store.commit("setUser", response.data.data);
          this.$router.push({
            name: "profile"
          });
        })
        .catch(error => {
          this.showFailure = true;
          this.showSuccess = false;
          this.failMessage = error.response.data.message;
          console.dir(error);
        });
    },
    cancelEdit: function() {
      this.editingUser = false;
      $(".edit-label").show();
      $(".edit-input").hide();
    },
    saveUser: function() {
      const user = this.$store.state.user;
      console.log(user);
      axios
        .put("/api/users/" + user.id, user)
        .then(response => {
          this.showSuccess = true;
          this.showFailure = false;
          this.successMessage = "User updated";

          Vue.set(this.user, response.data.data);
          this.editingUser = false;
          this.$store.commit("setUser", response.data.data); //TO DO: atualizar o user, para que depois de fazer save seja visto
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
  background: #00c6ff;
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
  width: 60%;
  height: 90%;
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

.profile-shift-btn {
  border: none;
  border-radius: 1.5rem;
  width: 30%;
  margin-top: 4%;
  padding: 2%;
  font-weight: 600;
  color: #6c757d;
  cursor: pointer;
}

.profile-shift {
  padding: 14%;
  margin-top: -15%;
  text-align: center;
}

.profile-shift p {
  font-size: 16px;
  font-weight: 600;
  margin-top: 7%;
  text-align: center;
}

.profile-shift a {
  text-decoration: none;
  color: #212529b8;
  font-weight: 600;
  font-size: 13px;
}

.profile-info {
  padding: 2%;
}

.profile-info p {
  font-size: 15px;
  color: #212529b8;
  font-weight: 600;
  text-align: center;
}
</style>
