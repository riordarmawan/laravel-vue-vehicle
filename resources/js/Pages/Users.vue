<template>
  <Head title="Dashboard" />

<AuthenticatedLayout>
  <div>
    <h1 class="text-3xl font-bold mb-4">Users Page</h1>
    <users-table></users-table>
  </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import UsersTable from '@/Components/UsersTable.vue';
</script>