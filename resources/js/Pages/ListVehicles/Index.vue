<!-- resources/js/Components/UsersTable.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const vehicles = ref([]);

const getListVihicle = () => {
  axios.get(route('listVehicle')).then(({ data }) => {
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
    <div class="grid grid-cols-6 gap-4">
      <div class="col-start-1 col-end-3">
        <h1 class="text-2xl font-bold mb-4">Daftar Mobil</h1>
      </div>
      <div class="col-end-8 col-span-1">
        <button @click="exportToExcel" class="px-4 py-1 bg-blue-500 text-white rounded">
          Export to Excel
        </button>
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
        </tr>
      </tbody>
    </table>
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
