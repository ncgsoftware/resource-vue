<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import NavLink from "@/Components/NavLink.vue";
</script>

<template>
  <AdminLayout title="User Administration">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Administration Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between pb-10">
              <h3 class="bold text-xl">Available Actions</h3>
            </div>

            <NavLink v-if="$page.props.auth.user.permissions.view_admin_user_list" :href="route('admin.users.index')" >
              <img class="size-16 rounded-full object-cover" src="/assets/images/users-94.png" alt="Users">
              <span class="text-xl ml-3">Manage Users</span>
            </NavLink>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>

</template>
