<template>
    <div class="container mt-4 job-details">
      <button @click="$router.back()" class="btn btn-secondary mb-3">⬅ Go Back</button>
      <div v-if="job" class="card p-4">
        <h2>{{ job.title }}</h2>
        <p><strong>Description:</strong></p>
        <p v-html="job.description"></p>
      </div>
      <p v-else>Loading job details...</p>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from "vue";
  import { useRoute } from "vue-router";
  import axios from "axios";
  
  const route = useRoute();
  const job = ref<{ id: number; title: string; description: string; } | null>(null);
  
  const fetchJobDetails = async (id: string) => {
    try {
      const response = await axios.get(`http://localhost:8000/api/jobs/${id}`);
      job.value = response.data?.data;
    } catch (error) {
      console.error("Error fetching job:", error);
    }
  };
  
  onMounted(() => {
    fetchJobDetails(route.params.id as string);
  });
  </script>
<style lang="css" scoped>
.job-details {
  min-width: 880px;
}
</style>