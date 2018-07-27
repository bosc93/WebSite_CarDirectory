<template>
  <section>
    <div class="divInputCityConcession">
      <label></label>
      <b-form-input id="inputCityConcession"
                    v-model="city"
                    type="text"
                    placeholder="Ville des concessions voulues"
                    :formatter="format"
                    lazy-formatter>
      </b-form-input>
    </div>
    <br/>
    <div class="mainContainer" v-for="(concession, index) in concessions" :key="index">
      <div class="container" v-if="concession.ville.includes(city.charAt(0).toUpperCase() + city.slice(1)) || city === ''"> <!-- 1ere lettre en majuscule -->
        <div class="card">
          <div class="row">
              <div class="col-md-5">
                <a :href="'/concessions/' + concession.idConcession">
                  <div class="card-img-bottom"></div>
                </a>
              </div>
            <div class="col-md-6">
              <div class="card-block">
                <a :href="'/concessions/' + concession.raisonSociale">
                  <h4 class="card-title">{{ concession.raisonSociale }}</h4>
                </a>
                <p class="card-text">{{ concession.description }}</p>
                <p class="card-text">{{ concession.ville }}</p>
                <p class="card-text">Avis :</p>
              </div>
            </div>
          </div>
        </div>
        <br/>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'principalList',
  props: ['name'],
  data () {
    return {
      concessions: [],
      city: '',
      inputConcession: ''
    }
  },
  filters: {
    nameConcession: function (value) {
      if (!value) return ''
      value = value.toString()
      return '/concessions/Concession test'
    }
  },
  mounted: function () {
    this.getAllConcession()
  },
  methods: {
    format (value, event) {
      var res = ''
      var upperCase = true
      for (var i = 0; i < value.length; ++i) {
        var c = value.charAt(i)

        upperCase = upperCase && !/^ ?[-)]/.test(value.charAt(i + 1) + value.charAt(i + 2))
        res += upperCase ? c.toUpperCase() : c.toLowerCase()

        var upperCaseChar = /[-!)\r\n.?]/.test(c)
        if (upperCaseChar || !/\s/.test(c)) {
          upperCase = upperCaseChar
        }
      }

      return res
    },
    getAllConcession: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_list_concession') // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer toutes les concessions
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
.card-img-bottom {
  color: #fff;
  height: 10rem;
  display:block;
  width:auto;
  margin-top: 1%;
  margin-bottom: 1%;
  margin-left: 1%;
  margin-right: 1%;
  background: url(https://www.evo-park.com/wp-content/uploads/2016/04/evopark-parking-aerien-multi-etages-concessionnaire-voiture.jpg) center no-repeat;
  background-size: cover;
}
.container {
  width: 50%; /* Aggrandir chaque élement de la liste */
}
.divInputCityConcession {
  text-align: center;
  margin-left: 50%;
  transform: translateX(-50%);
}
</style>
