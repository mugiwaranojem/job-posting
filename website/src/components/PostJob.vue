<template>
    <div class="container mt-4">
      <div v-if="successMessage" class="alert alert-success" role="alert">
        {{ successMessage }}
      </div>
      <div class="card p-4 shadow">
        <h4 class="mb-3">Post a Job</h4>
        <form @submit.prevent="postJob">
          <!-- Job Title -->
          <div class="mb-3">
            <label for="job-title" class="form-label">Job Title:</label>
            <input
              type="text"
              id="job-title"
              class="form-control"
              v-model="job.title"
              :class="{ 'is-invalid': job.title === '' && submitted }"
              placeholder="Enter job title"
            />
            <div class="invalid-feedback">Title is required.</div>
          </div>
  
          <!-- Job Description -->
          <div class="mb-3">
            <label for="job-description" class="form-label">Job Description:</label>
            <!-- <textarea
              id="job-description"
              class="form-control"
              v-model="job.description"
              :class="{ 'is-invalid': job.description === '' && submitted }"
              rows="4"
              placeholder="Enter job description"
            ></textarea> -->
            <Editor
              v-model="job.description"
              apiKey="zc0vndqw9w4mpfomizdpc3thtgu9gpper2bx0bysy041n42h"
              :init="{
                height: 400,
                menubar: false,
                plugins: 'lists link image code',
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code',
              }"
            />
            <div class="invalid-feedback">Description is required.</div>
          </div>
  
          <!-- Contact Email -->
          <div class="mb-3 mt-3">
            <label for="job-email" class="form-label">Contact Email:</label>
            <input
              type="email"
              id="job-email"
              class="form-control"
              v-model="job.email"
              :class="{ 'is-invalid': !validateEmail(job.email) && submitted }"
              placeholder="Enter contact email"
            />
            <div class="invalid-feedback">Valid email is required.</div>
          </div>
  
          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary mt-2" :disabled="loading">
            <span v-if="loading" class="spinner-border spinner-border-sm mr-1"></span>
            <span v-if="loading">Submitting...</span>
            <span v-else>Submit Job</span>
            </button>

        </form>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref } from "vue";
  import axios from "axios";
  import { eventBus } from "@/events/eventBus";
  import Editor from "@tinymce/tinymce-vue";

  const job = ref({
    title: "",
    description: "",
    email: "",
  });
  const loading = ref(false);
  const submitted = ref(false);
  const successMessage = ref('');
  const content = ref('');
  
  const validateEmail = (email: string) => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
  };
  
  const postJob = async () => {
    submitted.value = true;
    loading.value = true;

    try {
        await axios.post("http://localhost:8000/api/jobs", {
            title: job.value.title,
            description: job.value.description,
            contact_email: job.value.email
        });
        job.value = { title: "", description: "", email: "" };
        loading.value = false;
        successMessage.value = 'Job Posted!';
        submitted.value = false;
        eventBus.emit("fetch-jobs");
    } catch (error) {
        console.error("Error fetching jobs:", error);
        loading.value = false;
        submitted.value = false;
    }
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 600px;
  }
  .card {
    border-radius: 10px;
  }
  </style>
  