<template>
  <div>
    <img class="img" src="../../assets/404_NotFound.jpg" alt="404_NotFound">
  </div>
</template>

<script>
export default {
  name: 'pageNotFound',
  data () {
    return {
      msg: '404 - Page indisponible'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.img {
  height: 57%;
  width: 57%;
  margin: 0;
  padding: 0;
  margin-left: 20%;
}
</style>
