<script setup lang="ts">
import JobListItem from './JobListItem.vue'
import ToolingIcon from './icons/IconTooling.vue'

import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { eventBus } from "@/events/eventBus";

interface Job {
  id: number;
  title: string;
  description: string;
  created_at: string;
}

const jobs = ref<Job[]>([]);
const loading = ref<boolean>(false);

// Fetch jobs
const fetchJobs = async () => {
  loading.value = true;
  try {
    const response = await axios.get("http://localhost:8000/api/jobs");
    jobs.value = response.data?.data;
    loading.value = false;
  } catch (error) {
    console.error("Error fetching jobs:", error);
    loading.value = false;
  }
};

const truncatedText= (text: string): string => {
  const maxLength = 200;
  return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
};

onMounted(() => {
  eventBus.on("fetch-jobs", fetchJobs);
  fetchJobs();
});
</script>

<template>
  <div  v-if="loading" class="spinner-border m-5" role="status"></div>
  <div v-else>
    <JobListItem  v-for="job in jobs">
      <template #icon>
        <ToolingIcon />
      </template>
      <template #heading>{{ job.title }}</template>

      <div v-html="truncatedText(job.description)"></div>
      <br />
      <RouterLink :to="`/job/${job.id}`">View Job</RouterLink>
    </JobListItem>
  </div>
</template>
