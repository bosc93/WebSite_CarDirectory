<template>
  <div class="general">
    <div id="fond">
        <div class="ruban">
          <div v-for="(concession, index) in concessions" :key="index">
            <h2>{{ concession.raisonSociale }}</h2>
          </div>
        </div>
        <div class="ruban_gauche"></div>
        <div class="ruban_droit"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'titleConcession',
  data () {
    return {
      idConcession: this.$route.params.id,
      concessions: []
    }
  },
  mounted: function () {
    this.getAllConcession()
  },
  methods: {
    getAllConcession: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_concession&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer la concession par id
        .then(function (response) {
          this.concessions = response.data
          console.log(this.concessions)
        })
        .catch(function (error) {
          console.log(error)
        })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
#fond {
position: relative;
margin: 0px auto;
width: 350px;
background: #fff;
border-radius: 5px;
box-shadow: 0px 0px 8px rgba(0,0,0,0.3);
z-index: 10;
height:110px;
}
.ruban {
background: #b1c70d;
height: 50px;
width: 380px;
position: relative;
left:-15px;
top: 30px;
float: left;
box-shadow: 0px 0px 4px rgba(0,0,0,0.55);
z-index: 100;
}
.ruban h2 {
font-size: 25px;
color: #fff;
text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
text-align: center;
margin:10px;
}
.ruban_gauche {
border-color: transparent #7e9202 transparent transparent;
border-style:solid;
border-width:15px;
height:0px;
width:0px;
position: relative;
left: -30px;
top: 65px;
z-index: -1;  /*s'affichera sous le rectangle  */
}
.ruban_droit {
border-color: transparent transparent transparent #7e9202;
border-style:solid;
border-width:15px;
height:0px;
width:0px;
position: relative;
left: 350px;
top: 35px;
z-index: -1;
}
</style>
