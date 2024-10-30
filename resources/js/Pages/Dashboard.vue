<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import UsersTable from '@/Components/UsersTable.vue';
import ListVehicle from '@/Pages/ListVehicles/Index.vue'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- <div>
            <users-table></users-table>
        </div> -->

        <div>
           <list-vehicle></list-vehicle>
        </div>
    </AuthenticatedLayout>
</template>
