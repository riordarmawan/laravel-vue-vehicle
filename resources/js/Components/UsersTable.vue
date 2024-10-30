<!-- resources/js/Components/UsersTable.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// const users = ref([]);

// const fetchUsers = async () => {
//   try {
//     const response = await axios.get('/api/users');
//     users.value = response.data;
//   } catch (error) {
//     console.error('Error fetching users:', error);
//   }
// };

// const exportToExcel = () => {
//   window.location.href = '/api/users/export';
// };

// onMounted(fetchUsers);

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
    <h1 class="text-2xl font-bold mb-4">Daftar Mobil</h1>
    <table class="min-w-full bg-white border">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">ID</th>
          <th class="py-2 px-4 border-b">Brand</th>
          <th class="py-2 px-4 border-b">Name</th>
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
    <button @click="exportToExcel" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
      Export to Excel
    </button>
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
