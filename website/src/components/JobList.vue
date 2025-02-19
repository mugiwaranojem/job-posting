<script setup lang="ts">
import JobListItem from './JobListItem.vue'
import ToolingIcon from './icons/IconTooling.vue'

import { ref, computed, onMounted } from "vue";
import axios from "axios";

interface Job {
  id: number;
  title: string;
  description: string;
  created_at: string;
}

const jobs = ref<Job[]>([]);

// Fetch jobs
const fetchJobs = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/jobs"); // Replace with actual API
    jobs.value = response.data;
  } catch (error) {
    console.error("Error fetching jobs:", error);
  }
};
onMounted(fetchJobs);
</script>

<template>
  <JobListItem>
    <template #icon>
      <ToolingIcon />
    </template>
    <template #heading>Tooling</template>

    This project is served and bundled with
    <a href="https://vite.dev/guide/features.html" target="_blank" rel="noopener">Vite</a>. The
    recommended IDE setup is
    <a href="https://code.visualstudio.com/" target="_blank" rel="noopener">VSCode</a>
    +
    <a href="https://github.com/johnsoncodehk/volar" target="_blank" rel="noopener">Volar</a>. If
    you need to test your components and web pages, check out
    <a href="https://vitest.dev/" target="_blank" rel="noopener">Vitest</a>
    and
    <a href="https://www.cypress.io/" target="_blank" rel="noopener">Cypress</a>
    /
    <a href="https://playwright.dev/" target="_blank" rel="noopener">Playwright</a>.

    <br />

    More instructions are available in
    <a href="javascript:void(0)" @click="openReadmeInEditor"><code>README.md</code></a
    >.
  </JobListItem>
</template>
