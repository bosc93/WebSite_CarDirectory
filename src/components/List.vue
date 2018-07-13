<template>
  <div class="general">
    <NavBar></NavBar>
  </div>
</template>

<script>
import NavBar from './subcomponents/NavBar'
export default {
  name: 'welcome',
  components: {NavBar},
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
