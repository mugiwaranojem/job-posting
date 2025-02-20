<script setup lang="ts">
import JobList from '../components/JobList.vue'
import PostJob from '../components/PostJob.vue'
</script>

<template>
  <div class="wrapper">
    <PostJob />
  </div>
  <main id="main-list">
    <JobList />
  </main>
</template>

<style scoped>
#main-list {
  min-width: 600px;
}

.wrapper {
  display: flex;
  place-items: flex-start;
  flex-wrap: wrap;
}
</style>
