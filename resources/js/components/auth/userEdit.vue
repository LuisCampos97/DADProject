<template>
<!-- template só pode ter um unico root element -->
<div class="jumbotron" v-if="editingUser">
    <div class="row">
        <div class="col-md-2">
            <button class="profile-edit-btn"  style="float: right" @click.prevent="saveUser()">Save</button>
        </div>
        <div class="col-md-2">
            <button class="profile-edit-btn" style="float: right" @click.prevent="cancelEdit()">Cancel</button>
        </div>
        <div class="col-md-2">
            <button class="profile-edit-btn" style="float: right" @click.prevent="submitFile()">Submit photo</button>
            <!--TO DO: este botao é redundante, o botao Save é que vai chamar o método submitFile para alem do SaveUser -->
        </div>
    </div>
</div>
</template>

<script>
module.exports = {
    props: ["currentUser", "editingUser"],
    data: function () {
        return {};
    },
    methods: {
        cancelEdit: function () {
            this.$emit("cancel-edit");
        },
        saveUser: function () {
            this.$emit("save-user");
        },
        submitFile: function () {
            this.$emit("submit-file");
        }
    },
    mounted() {}
};
</script>