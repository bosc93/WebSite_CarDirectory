<template>
  <div class="general">
    <div v-for="(concession, index) in concessions" :key="index">
      <div>
        <img class="icon_description" src="../../assets/icon_address.png" alt="address">
        {{ concession.adresse + ', ' + concession.codePostal + ', ' + concession.ville + ', ' + concession.pays }}
      </div>
      <div>
        <img class="icon_description" src="../../assets/icon_tel.png" alt="tel">
        {{ concession.telephone }}
      </div>
      <div>
        <img class="icon_description" src="../../assets/icon_webSite.png" alt="webSite">
        <a :href="concession.siteWeb">{{ concession.siteWeb | site}}</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'details',
  data () {
    return {
      idConcession: this.$route.params.id,
      concessions: []
    }
  },
  filters: {
    site: function (value) {
      if (!value) return ''
      value = value.toString()
      return 'Site web'
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
