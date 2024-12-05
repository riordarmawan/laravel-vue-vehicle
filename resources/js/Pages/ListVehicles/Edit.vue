<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

const props = defineProps({
  vehicle: Object
})

const form = ref({
  id: props.vehicle.id,
  brand: props.vehicle.brand || '',
  name: props.vehicle.name || '',
  price: props.vehicle.price || '',
  seat: props.vehicle.seat || '',
  transmission: props.vehicle.transmission || '',
  type: props.vehicle.type || '',
});

// Metode untuk menyimpan perubahan
const submitEdit = () => {
  Swal.fire({
    title: 'Are you sure?',
    text: 'You want to save these changes?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, save it!',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if(result.isConfirmed) {
          // Jika user mengkonfirmasi, lanjutkan untuk mengupdate
          Inertia.put(route('listVehicle.updateVehicle', props.vehicle.id), form.value, {
          onSuccess: () => {
            Swal.fire('Updated!', 'Vehicle data has been updated.', 'success');
          },
          onError: (errors) => {
            Swal.fire('Error!', 'Failed to update vehicle data.', 'error');
          },
      });
    }
  })
};

// Metode untuk membatalkan edit
const cancelEdit = () => {
  Inertia.get(route('listVehicle.index'));
};

const init = () => {
  // loadVehicleData();
  // updateVehicle();
}

init()
</script>

<template>
  <div class="max-w-4xl my-5 mx-auto p-10 bg-white rounded-lg shadow-2xl">
    <h2 class="text-3xl font-bold text-center text-indigo-600 mb-8">Edit Vehicle</h2>

    <form @submit.prevent="submitEdit" class="grid grid-cols-2 gap-6">
      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Brand</label>
        <input v-model="form.brand" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Brand">
      </div>

      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Product Name</label>
        <input v-model="form.name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Product Name">
      </div>

      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Price</label>
        <input v-model="form.price" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Price">
      </div>

      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Seat</label>
        <input v-model="form.seat" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Seat Capacity">
      </div>

      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Transmission</label>
        <input v-model="form.transmission" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Transmission">
      </div>

      <div class="w-full">
        <label class="block mb-2 text-sm font-semibold text-gray-700">Type</label>
        <input v-model="form.type" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Vehicle Type">
      </div>

      <div class="text-center col-span-2 mt-8">
        <button @click="cancelEdit" type="button" class="px-6 py-3 mr-2 bg-gray-500 text-white rounded-lg">
          Cancel
        </button>
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Submit
        </button>
      </div>
    </form>
  </div>
</template>