<template>
  <div class="jumbotron" v-if="currentUser.type == 'manager'">
    <div class="alert alert-success" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>
    <a class="btn btn btn-info" v-on:click.prevent="openMenuItemAddComponent()">
      <i class="fas fa-plus"></i> Add Menu Item
    </a>
    <add-menuitem
      :addingMenuItem="addingMenuItem"
      v-on:cancel-add="closeMenuItemAddComponent()"
      v-on:edit-menuitem="closeMenuItemAddComponent()"
    ></add-menuitem>
    <br>
    <br>
    <InvoiceManage></InvoiceManage>
    <MealManage></MealManage>
    <h3>Menu Items</h3>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Item ID</th>
          <th>Name</th>
          <th>Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="item in items.data" :key="item.id">
        <tr>
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.type }}</td>
          <td>
            <a class="btn btn btn-info" v-on:click.prevent="openMenuItemEditComponent(item)">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a class="btn btn btn-danger" v-on:click.prevent="deleteItem(item)">
              <i class="fas fa-trash"></i> Delete
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <pagination :data="items" @pagination-change-page="getItems"></pagination>
    </div>
    <edit-menuitem
      :item="currentItem"
      :editingMenuItem="editingMenuItem"
      v-on:cancel-edit="closeMenuItemEditComponent()"
      v-on:edit-menuitem="closeMenuItemEditComponent()"
    ></edit-menuitem>
  </div>
</template>

<script>
export default {
  props: ["currentUser"],
  data() {
    return {
      items: {},
      showMessage: false,
      message: "",
      editingMenuItem: false,
      currentItem: {},
      addingMenuItem: false
    };
  },
  methods: {
    getItems(page = 1) {
      axios.get("/api/itemsPaginate?page=" + page).then(response => {
        this.items = response.data;
      });
    },
    deleteItem(item) {
      axios.delete("api/items/" + item.id).then(response => {
        this.showMessage = true;
        this.message = `Item "${item.name}" deleted`;
        this.getItems();
      });
    },
    openMenuItemEditComponent(item) {
      this.currentItem = item;
      this.editingMenuItem = true;
    },
    closeMenuItemEditComponent() {
      this.getItems();
      this.editingMenuItem = false;
    },
    openMenuItemAddComponent() {
      this.addingMenuItem = true;
    },
    closeMenuItemAddComponent() {
      this.addingMenuItem = false;
    }
  },
  mounted() {
    this.getItems();
  }
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
</style>
