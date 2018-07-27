<template>
  <div class="general">
    <NavBar></NavBar>
    <br/>
    <TitleConcession></TitleConcession>
    <br/>
    <Carousel></Carousel>
    <br/>
    <Details></Details>
    <br/>
    <TimeTable></TimeTable>
  </div>
</template>

<script>
import NavBar from './subcomponents/NavBar'
import Carousel from './subcomponents/Carousel'
import TitleConcession from './subcomponents/TitleConcession'
import Details from './subcomponents/Details'
import TimeTable from './subcomponents/TimeTable'
export default {
  name: 'DetailsConcession',
  components: {NavBar, Carousel, TitleConcession, Details, TimeTable},
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
