<template>
  <div class="general">
    <NavBar></NavBar>
    <PageNotFound></PageNotFound>
  </div>
</template>

<script>
import NavBar from './subcomponents/NavBar'
import PageNotFound from './subcomponents/PageNotFound'
export default {
  name: 'DetailsConcession',
  components: {NavBar, PageNotFound},
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
