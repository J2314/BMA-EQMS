<template>
      <ion-content>
    <div class="pdf">
      <h2>Policy Document</h2>
      <div v-if="loading">Loading...</div>
      <div v-else>
        <div v-html="policyContent"></div>
      </div>
    </div>
</ion-content>
  </template>
  
  <script>
  export default {
    data() {
      return {
        loading: true,
        policyContent: `
          <h3>Privacy Policy</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus euismod augue sit amet 
            tortor placerat tempus. Sed vehicula velit ac diam euismod, et lobortis mauris faucibus. 
            Nulla facilisi. Sed in dui mi. Integer ut lacus ac est imperdiet ultrices. Donec in libero 
            libero. Fusce fermentum ac urna a eleifend. Nulla ut nulla vitae purus efficitur convallis. 
            Aenean nec pharetra odio, a viverra quam.
          </p>
          <h3>Terms of Service</h3>
          <p>
            Duis ac felis fermentum, sagittis diam at, feugiat nisi. Phasellus consectetur purus non 
            consectetur cursus. Donec vel augue a sapien ullamcorper convallis vel id nunc. Integer 
            sodales erat et nisl varius, sed commodo ex laoreet. Integer fringilla dui nec mauris 
            pellentesque, at laoreet est rhoncus. Morbi consectetur lectus non lacinia tincidunt. 
            Curabitur scelerisque odio sit amet magna dapibus, et tincidunt felis luctus.
          </p>
        `
      };
    },
    mounted() {
      // Simulate loading delay
      setTimeout(() => {
        this.loading = false;
      }, 1000);
    }
  };
  </script>
  
  <style scoped>
  .pdf {
    margin: 5%;
  }
  </style>
  