<script setup>

</script>

<template>
  <div class="max-w-4xl my-5 mx-auto p-10 bg-white rounded-lg shadow-2xl">
    <!-- Title Section -->
    <h2 class="text-3xl font-bold text-center text-indigo-600 mb-8">Create Vehicle</h2>

    <div class="grid grid-cols-2 gap-6">
      <!-- Form Fields -->
      <form class="w-full">
        <label for="" class="block mb-2 text-sm font-semibold text-gray-700">Brand</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Brand">
      </form>

      <form class="w-full">
        <label for="" class="block mb-2 text-sm font-semibold text-gray-700">Product Name</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Product Name">
      </form>

      <form class="w-full">
        <label for="" class="block mb-2 text-sm font-semibold text-gray-700">Price</label>
        <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Price">
      </form>

      <form class="w-full">
        <label for="" class="block mb-2 text-sm font-semibold text-gray-700">Seat</label>
        <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Seat Capacity">
      </form>

      <form class="w-full">
        <label for="" class="block mb-2 text-sm font-semibold text-gray-700">Type</label>
        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-3 shadow-sm" placeholder="Enter Vehicle Type">
      </form>
    </div>

    <!-- Submit Button -->
    <div class="text-center mt-8">
      <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Submit
      </button>
    </div>
  </div>

</template>