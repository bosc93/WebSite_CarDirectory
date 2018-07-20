<template>
    <tbody>
        <div v-for="concession in concessions" :key="concession" class="card" style="width: 18rem;">
            <img class="card-img-top" src="https://www.evo-park.com/wp-content/uploads/2016/04/evopark-parking-aerien-multi-etages-concessionnaire-voiture.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ concession.raisonSociale }}</h5>
                <p class="card-text">{{ concession.description }}</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </tbody>
</template>

<script>
export default {
  name: 'principalList',
  props: ['name'],
  data () {
    return {
      concessions: []
    }
  },
  mounted: function () {
    this.getAllConcession()
  },
  methods: {
    getAllConcession: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/ajaxfile.php') // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer toutes les concessions
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
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
