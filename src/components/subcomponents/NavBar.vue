<template>
  <b-navbar toggleable="md" type="dark" variant="primary">

  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

      <b-navbar-brand href="/">
        <img src="https://placekitten.com/g/30/30" class="d-inline-block align-top" alt="BV">
        {{ msg }}
      </b-navbar-brand>

  <b-collapse is-nav id="nav_collapse">

    <b-navbar-nav v-if="this.$route.path === '/'"> <!-- Si on est sur la page d'acceuil -->
      <b-button @click="showModal" variant="primary">
        <b-nav-item>Présentation de l'annuaire</b-nav-item>
      </b-button>
      <b-modal ref="myModalRef" hide-footer title="Présentation de l'annuaire">
        <div class="d-block text-center">
          Description de l'annuaire et de ses avantages
        </div>
        <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Fermer</b-btn>
      </b-modal>
    </b-navbar-nav>

    <!-- Right aligned nav items -->
    <b-navbar-nav class="ml-auto">

      <b-nav-form>
        <b-form-input v-model="inputConcession" size="sm" class="mr-sm-2" type="text" placeholder="Rechercher concession"/>
        <b-button v-on:click="searchConcession" size="sm" class="my-2 my-sm-0">Rechercher</b-button>
      </b-nav-form>

      <b-nav-item-dropdown text="Langue" right>
        <b-dropdown-item href="#">FR</b-dropdown-item>
        <b-dropdown-item href="#">EN</b-dropdown-item>
      </b-nav-item-dropdown>

      <b-nav-item-dropdown right>
        <!-- Using button-content slot -->
        <template slot="button-content">
          <em>Utilisateur</em>
        </template>
        <b-dropdown-item href="#">Profil</b-dropdown-item>
        <b-dropdown-item href="#">Déconnection</b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>

  </b-collapse>
</b-navbar>
</template>

<script>
export default {
  name: 'navBar',
  data () {
    return {
      msg: 'CarDirectory',
      inputConcession: null,
      concessions: []
    }
  },
  mounted: function () {
    this.getAllConcession()
  },
  methods: {
    showModal () {
      this.$refs.myModalRef.show()
    },
    hideModal () {
      this.$refs.myModalRef.hide()
    },
    searchConcession: function () {
      var i
      var boolSearch = false
      var nbConcession = this.concessions.length
      if (this.inputConcession) {
        for (i = 0; i < nbConcession; i++) {
          if (this.inputConcession.charAt(0).toUpperCase() + this.inputConcession.slice(1) === this.concessions[i].raisonSociale) {
            document.location.href = '/concessions/' + this.concessions[i].raisonSociale
            boolSearch = true
          }
        }
        if (!boolSearch) {
          alert('Aucune concession correspondante, veuillez corriger votre recherche !')
        }
      }
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
