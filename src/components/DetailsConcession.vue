<template>
  <div class="general">
    <NavBar></NavBar>
    <BlocImage></BlocImage>
  </div>
</template>

<script>
import NavBar from './subcomponents/NavBar'
import BlocImage from './subcomponents/BlocImage'
export default {
  name: 'DetailsConcession',
  components: {NavBar, BlocImage},
  data () {
    return {}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.general {
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>
