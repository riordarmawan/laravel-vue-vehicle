<!-- resources/js/Components/UsersTable.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const goToCreate = () => {
  Inertia.get(route('listVehicle.createVehicle'))
}

const vehicles = ref([]);

const getListVihicle = () => {
  axios.get(route('listVehicle.vehicle')).then(({ data }) => {
    const res = data.data.map(item => ({
      ...item,
      price: new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
      }).format(item.price)
    }));

    vehicles.value = res

    console.log('CEK DATA', vehicles.value)
  })
}

const exportToExcel = () => {
  window.location.href = route('vehicles.export');
};

const init = () => {
  getListVihicle();
}

init()
</script>

<template>
  <div class="p-6 bg-gray-100">
    <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold mb-4">List Mobil</h2>
            <div class="flex space-x-2">
                <button @click="goToCreate" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create</button>
                <button @click="exportToExcel" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Export Excel</button>
            </div>
        </div>
  
    <table class="min-w-full bg-white border rounded-lg overflow-hidden">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">ID</th>
          <th class="py-2 px-4 border-b">Brand</th>
          <th class="py-2 px-4 border-b">Product Name</th>
          <th class="py-2 px-4 border-b">Price</th>
          <th class="py-2 px-4 border-b">Seat</th>
          <th class="py-2 px-4 border-b">Transmission</th>
          <th class="py-2 px-4 border-b">Type</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="vehicle in vehicles" :key="vehicle.id">
          <td class="py-2 px-4 border-b">{{ vehicle.id }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.brand }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.name }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.price }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.seat }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.transmission }}</td>
          <td class="py-2 px-4 border-b">{{ vehicle.type }}</td>
          <td class="py-2 px-4 border-b">
            <button @click="editVehicle(vehicle.id)" class="text-blue-500 hover:underline">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
      <h2 class="text-xl font-bold mb-4">Edit Vehicle</h2>
      <div class="mb-4">
        <label class="block text-gray-700">Brand</label>
        <input v-model="editForm.brand" class="border p-2 w-full" />
      </div>
      <!-- Tambahkan input lain untuk field lainnya -->
      <button @click="updateVehicle" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">
        Save Changes
      </button>
      <button @click="showEditModal = false" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">
        Cancel
      </button>
    </div>
  </div>

</template>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}
</style>
