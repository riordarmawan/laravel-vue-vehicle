<!-- resources/js/Components/UsersTable.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import { route } from 'ziggy-js';
import { jsPDF } from 'jspdf';
import html2canvas from 'html2canvas';
import Swal from 'sweetalert2';

//  Start function upload
const showUploadModal = ref(false);
const uploadForm = ref({
  text: '',
  description: '',
  file: null,
});

const handleFileUpload = (event) => {
  uploadForm.value.file = event.target.files[0];
};

const uploadedImageUrl = (fileName) => `/uploads/${fileName}`;

const uploadData = () => {
  // Data dikirim ke server menggunakan FormData, yang mendukung pengunggahan file dan data teks secara bersamaan.
  const formData = new FormData();
  formData.append('text', uploadForm.value.text);
  formData.append('description', uploadForm.value.description);
  formData.append('file', uploadForm.value.file);

  axios.post(route('listVehicle.upload'), formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
  .then(() => {
    Swal.fire({
      title: 'Success!',
      text: 'File uploaded successfully!',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then(() => {
      // window.location.reload(); // Refresh halaman
      getDataUpload(); // Memperbarui daftar file
      showUploadModal.value = false; // Menutup modal upload
      uploadForm.value = { description: '', file: null }; // Reset form
    }).catch((error) => {
        Swal.fire({
        title: 'Error!',
        text: 'Failed to upload data. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK',
      });
    });
  })
};

const listUploadedFiles = ref([])

const getDataUpload = () => {
  axios.get(route('listVehicle.dataUploaded')).then(({ data }) => {
    listUploadedFiles.value = data.data

    console.log('CEK :',listUploadedFiles.value)
  }).catch(error => {

  })
}

//  End function upload

const goToCreate = () => {
  Inertia.get(route('listVehicle.createVehicle'))
}

const goToEdit = (id) => {
  Inertia.get(route('listVehicle.editVehicle', id));
};


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

//  Start function export excel
const exportToExcel = () => {
  window.location.href = route('vehicles.export');
};
//  End function export excel

//  Start function export pdf
const exportToPdf = () => {
  const tableElement = document.querySelector('.min-w-full'); //elemen tabel

  html2canvas(tableElement).then((canvas) => {
    const imgData = canvas.toDataURL('image/png'); // ubah ke format gambar
    const pdf = new jsPDF('p', 'mm', 'a4');

     // Atur ukuran halaman PDF
    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Tambahkan margin
    const margin = 5; // Margin dalam mm (kiri, kanan, atas, bawah)
    const maxImgWidth = pageWidth - 2 * margin;
    const maxImgHeight = pageHeight - 2 * margin;

    // Skala gambar agar sesuai dengan ukuran halaman
    const imgWidth = maxImgWidth;
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    // Posisi gambar dengan margin
    const posX = margin;
    const posY = margin;

     // Jika gambar melebihi tinggi halaman, tambahkan halaman baru
    if (imgHeight > maxImgHeight) {
      const imgPerPageHeight = maxImgHeight;

      while (posY + imgPerPageHeight <= imgHeight) {
        pdf.addImage(imgData, 'PNG', posX, posY, imgWidth, imgPerPageHeight);
        pdf.addPage(); // Tambahkan halaman baru
        posY = margin; // Reset posisi ke atas halaman baru
      }
    } else {
      pdf.addImage(imgData, 'PNG', posX, posY, imgWidth, imgHeight);
    }

    pdf.save('list-vehicles.pdf'); // Nama file PDF
  })
}
// End function export pdf

const init = () => {
  getListVihicle();
  getDataUpload();
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
                <button @click="showUploadModal = true" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Upload</button>
                <button @click="exportToPdf" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Export PDF</button>
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
            <button @click="goToEdit(vehicle.id)" class="text-blue-500 hover:underline">Edit</button>
          </td>

        </tr>
      </tbody>
    </table>
  </div>

  <section class="p-6 bg-gray-100">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Single Card -->
        <div v-for="file in listUploadedFiles" :key="file.id" class="bg-white shadow rounded-lg overflow-hidden">
          <img :src="`/storage/${file.file_path}`" alt="Uploaded File" class="w-full h-48 text-gray-600">
          <div class="p-4">
            <h2 class="text-lg font-bold">{{ file.file_name }}</h2>
            <p class="text-sm text-gray-600 mt-2">{{ new Date(file.created_at).toLocaleDateString() }}</p>
          </div>
        </div>
      </div>
    </section>

  <!-- <div v-if="uploadedImageUrl">
    <h3 class="mt-4">Uploaded Image:</h3>
    <img :src="uploadedImageUrl" alt="Uploaded File" class="mt-2 max-w-xs" />
  </div> -->

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

  <div v-if="showUploadModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
    <h2 class="text-xl font-bold mb-4">Upload Data</h2>
    <div class="mb-4">
      <label class="block text-gray-700">Enter Text</label>
      <input v-model="uploadForm.description" class="border p-2 w-full" rows="3"></input>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700">Choose File</label>
      <input type="file" @change="handleFileUpload" class="border p-2 w-full" />
    </div>
    <div class="flex justify-end space-x-2">
      <button @click="uploadData" class="px-4 py-2 bg-blue-500 text-white rounded">Upload</button>
      <button @click="showUploadModal = false" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
    </div>
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
