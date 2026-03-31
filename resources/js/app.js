import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue'; // This imports the Dashboard we wrote earlier

// This mounts your Vue code into the <div id="app"> in your welcome.blade.php
createApp(App).mount('#app');