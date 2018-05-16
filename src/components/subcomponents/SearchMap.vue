<template>
  <div class="search">
    <div class="icon_map">
      <img src="../../assets/searchIcon.png">
    </div>
    <div class="search_store">
      <div class="search_bar">
        <b-input-group prepend="Search">
          <b-form-input  placeholder="Ville ou concession"/>
          <b-input-group-append>
            <b-btn size="sm" text="Button" variant="success">Button</b-btn>
          </b-input-group-append>
        </b-input-group>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'searchMap'
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
  max-width: 5%;
  height: auto;
}
.icon_map {
  background-color: white;
  padding-top: 3%;
  padding-bottom: 3%;
  background-image: url("../../assets/fond_degradeBleu.jpg");
}
.search_store {
  background-image: url("../../assets/fond_degradeBleu.jpg");
}
.search_bar {
  display: block;
  margin-left: auto;
  margin-right: auto;
  padding-top: 1%;
  padding-bottom: 1%;
  width: 70%;
}
</style>
