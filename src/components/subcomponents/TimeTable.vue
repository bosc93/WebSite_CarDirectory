<template>
  <div class="general"> <!-- En haut : notes, a gauche : horaires, a droite : map -->
    <div v-for="(timetable, index) in timetables" :key="index">
      <div>
        <img class="icon_note" src="../../assets/icon_note.png" alt="note">
        {{ note }}
      </div>
      <div>
        <span>
          <ul class="list-group">
            <li class="list-group-item">{{ timetable.adresse }}</li>
            <li class="list-group-item">{{ timetable.adresse }}</li>
            <li class="list-group-item">{{ timetable.adresse }}</li>
          </ul>
        </span>
        <span>
          <img class="icon_description" src="../../assets/icon_tel.png" alt="tel">
          {{ timetable.telephone }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'timeTable',
  data () {
    return {
      idConcession: this.$route.params.id,
      timetables: [],
      note: '***' // En faire une table d'avis et de notation reliée à l'idConcession de la table concession
    }
  },
  mounted: function () {
    this.getAllConcession()
  },
  methods: {
    getAllConcession: function () { // Faire une table d'horaires reliée l'idConcession de la table concession
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_concession&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer la concession par id
        .then(function (response) {
          this.timetables = response.data
          console.log(this.timetables)
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
.general {
  width: 70%;
  text-align: center;
  margin-left: 50%;
  transform: translateX(-50%);
  border-radius:12px 0 12px 0;
  background: #f5f5f5;
  border:none;
  color:#555;
  font:bold 12px Verdana;
  padding:6px 0 6px 0;
  box-shadow:1px 1px 3px #999;
}
.icon_description {
  width: 3%
}
.icon_note {
  width: 5%
}
</style>
