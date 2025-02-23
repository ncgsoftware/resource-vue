<script setup>
import Pagination from "@/Components/Pagination.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pill from "@/Components/Pill.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps(['users', 'roles', 'selectedRole', 'query']);

const searchForm = useForm({
  query: props.query,
  page: 1,
});

const page = usePage();
const search = () => searchForm.get(page.url);
const clearSearch = () => {
  searchForm.query = "";
  search();
};
</script>

<template>
  <AdminLayout title="User Administration">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Administration
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="flex justify-between pb-10">
              <h3 v-if="selectedRole" class="bold text-xl">Role: {{ selectedRole.data.name }}</h3>
              <h3 v-else class="bold text-xl">All Users</h3>
            </div>

            <div class="border-b border-gray-200">
              <menu class="flex flex-wrap space-x-3 mb-4">
                <li>
                  <Pill :filled="!selectedRole"
                        :href="route('admin.users.index', { query: searchForm.query })">
                    <span class="font-bold text-lg group-hover:text-indigo-500">All Users</span>
                  </Pill>
                </li>
                <li v-for="role in roles.data" :key="role.id">
                  <Pill :filled="role.id === selectedRole?.data.id"
                        :href="route('admin.users.index', { role: role.id, query: searchForm.query })">
                    <span class="font-bold text-lg group-hover:text-indigo-500">{{ role.name }}</span>
                  </Pill>
                </li>
              </menu>

              <form class="mt-4 mb-4" @submit.prevent="search">
                <div>
                  <InputLabel class="sr-only" for="query">Search</InputLabel>
                  <div class="flex space-x-2 mt-1">
                    <TextInput id="query" v-model="searchForm.query" class="w-full" placeholder="Search..."/>
                    <SecondaryButton type="submit">Search</SecondaryButton>
                    <DangerButton v-if="searchForm.query" @click="clearSearch">Clear</DangerButton>
                  </div>
                </div>
              </form>
            </div>

            <table class="w-full mt-1">
              <thead>
              <tr>
                <th class="text-start"></th>
                <th class="text-start">Name</th>
                <th class="text-start">Email address</th>
                <th class="text-start">Role</th>
                <th></th>
              </tr>
              </thead>
              <tbody>

              <tr v-for="user in users.data" :key="user.id" class="border-t-gray-200 border-t">
                <td class="py-4">
                  <img :src="user.profile_photo_url" alt="" class="size-8 rounded-full object-cover">
                </td>
                <td class="py-4">{{ user.name }}</td>
                <td class="py-4">{{ user.email }}</td>
                <td class="py-4"><span v-for="display_role_name in user.roles_names">{{ display_role_name }}</span></td>
                <td class="flex py-4 justify-end">

                  <a v-if="user.can.disable" class="bg-gray-500 hover:bg-gray-600 mr-1 py-2 px-3 rounded-md text-white"
                     href="">
                    Disable
                  </a>

                  <a v-if="user.can.changerole"
                     class="bg-gray-500 hover:bg-gray-600 mr-1 py-2 px-3 rounded-md text-white"
                     href="">
                    Change Role
                  </a>

                  <form v-if="user.can.delete"
                        action="" method="post"
                        onsubmit="return confirm('Are you sure you want to delete this user?')"
                  >
                    <button
                        class="bg-red-400 hover:bg-red-500 py-2 px-3 rounded-md text-white">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
              </tbody>
            </table>
            <Pagination :meta="users.meta"/>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>

</style>