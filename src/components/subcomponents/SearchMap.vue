<template>
  <div class="searchMap">
    <div class="icon_map">
      <input type="image" src="https://theunrefined.com.au/wp-content/plugins/google-maps/assets/images/icons/greenmarker256.png" @click="geolocate" alt="geolocalisation" id="icon" class="icon"/>
    </div>
    <div class="search_store">
      <div class="search_bar">
        <b-input-group prepend="Recherchez">
          <gmap-autocomplete @place_changed="setPlace" placeholder="Adresse ou concession" class="addressMap"/>
          <b-input-group-append>
            <b-btn @click="addMarkerSearch" size="sm" text="Valid" variant="success">Valider</b-btn>
          </b-input-group-append>
        </b-input-group>
      </div>
    </div>
    <div>
      <br>
      <gmap-map
        :center="center"
        :zoom="zoom"
        style="width:100%;  height: 425px;"
      >
        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          @click="center=m.position"
        ></gmap-marker>
      </gmap-map>
    </div>
  </div>
</template>

<script>
export default {
  name: 'searchMap',
  props: ['name'],
  data () {
    return {
      center: {lat: 43.63144, lng: 3.84642},
      zoom: 12,
      markers: [],
      places: [],
      currentPlace: null
    }
  },
  mounted () {
    // this.geolocate()
  },
  methods: {
    // receives a place object via the autocomplete component
    setPlace (place) {
      this.currentPlace = place
    },
    addMarkerSearch () {
      // if(ville dans la barre de recherche && this.currentPlace)
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        }
        this.markers.push({ position: marker })
        this.places.push(this.currentPlace)
        this.center = marker
        this.currentPlace = null
      }
      this.zoom = 14
    },
    addMarkerGeolocalisation (latitude, longitude) {
      const marker = {
        lat: latitude,
        lng: longitude
      }
      this.markers.push({ position: marker })
      this.center = marker
      this.currentPlace = null
    },
    geolocate: function () {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.zoom = 15
        this.addMarkerGeolocalisation(position.coords.latitude, position.coords.longitude)
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.icon {
  display: block;
  margin-left: auto;
  margin-right: auto;
  max-width: 5%;
  height: auto;
}
.icon_map {
  background-color: white;
  padding-top: 1%;
  padding-bottom: 1%;
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
.addressMap {
  width: 80%;
}
</style>
