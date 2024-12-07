<template>
    <div>
      <h2>Affiliate Links</h2>
      <form @submit.prevent="saveLink">
        <input v-model="link.stream_id" placeholder="Stream ID" required />
        <input v-model="link.platform" placeholder="Platform" required />
        <input v-model="link.iframe_url" placeholder="Iframe URL" required />
        <input v-model="link.clickable_link" placeholder="Clickable Link" />
        <button type="submit">Save</button>
      </form>
      <ul>
        <li v-for="link in links" :key="link.id">
          {{ link.platform }} - {{ link.iframe_url }}
          <button @click="deleteLink(link.id)">Delete</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        links: [],
        link: { stream_id: '', platform: '', iframe_url: '', clickable_link: '' },
      };
    },
    mounted() {
      this.fetchLinks();
    },
    methods: {
      fetchLinks() {
        axios.get('/api/admin/affiliate-links').then((response) => {
          this.links = response.data;
        });
      },
      saveLink() {
        axios.post('/api/admin/affiliate-links', this.link).then(() => {
          this.fetchLinks();
        });
      },
      deleteLink(id) {
        axios.delete(`/api/admin/affiliate-links/${id}`).then(() => {
          this.fetchLinks();
        });
      },
    },
  };
  </script>
  