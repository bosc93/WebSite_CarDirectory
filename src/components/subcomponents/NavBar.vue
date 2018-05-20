<template>
  <b-navbar toggleable="md" type="dark" variant="primary">

  <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

    <b-navbar-brand href="#">
      <img src="https://placekitten.com/g/30/30" class="d-inline-block align-top" alt="BV">
      {{ msg }}
    </b-navbar-brand>

  <b-collapse is-nav id="nav_collapse">

    <b-navbar-nav>
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
        <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Rechercher concession"/>
        <b-button size="sm" class="my-2 my-sm-0" type="submit">Rechercher</b-button>
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
      msg: 'CarDirectory'
    }
  },
  methods: {
    showModal () {
      this.$refs.myModalRef.show()
    },
    hideModal () {
      this.$refs.myModalRef.hide()
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
