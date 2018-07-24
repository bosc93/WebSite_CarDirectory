<template>
  <div class="general">
    <NavBar></NavBar>
    <PrincipalList></PrincipalList>
  </div>
</template>

<script>
import NavBar from './subcomponents/NavBar'
import PrincipalList from './subcomponents/PrincipalList'
export default {
  name: 'Concessions',
  components: {NavBar, PrincipalList},
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
