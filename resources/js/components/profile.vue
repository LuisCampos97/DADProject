<template>
<div>
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="text-dark">{{title}}</h1>
            </div>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Photo</th>
                <th>User name</th>
                <th>Full name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="profile in profiles"  :key="profile.id">
                <td><img :src="'/storage/profiles/' + profile.photo_url"></td>
                <td>{{ profile.username }}</td>
                <td>{{ profile.name }}</td>
                <td>{{ profile.email }}</td>
            </tr>
        </tbody>
    </table>
</div>


</template>

<script>
module.exports = {
  data: function(){
    return {
      profiles: [],
      title: "Profile"
    };
  },
  methods: {
    getProfile: function() {
      axios.get("api/profiles").then(response => {
        this.profiles = response.data.data;
      });
    }
  },
  mounted() {
    this.getProfile();
  }
};
</script>

<style>

</style>
