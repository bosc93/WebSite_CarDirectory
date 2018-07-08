<template>
  <div class="searchMap">
    <div class="icon_map">
      <input type="image" src="https://theunrefined.com.au/wp-content/plugins/google-maps/assets/images/icons/greenmarker256.png" @click="geolocate" alt="geolocalisation" id="icon" class="icon"/>
    </div>
    <div class="search_store">
      <div class="search_bar">
        <b-input-group prepend="Recherchez">
          <b-form-input v-model="text" type="search" @place_changed="setPlace" id="address" placeholder="Adresse ou concession">{{ text }}</b-form-input>
          <b-input-group-append>
            <b-btn @click="addMarkerSearch" size="sm" text="Valid" variant="success">Valider</b-btn>
          </b-input-group-append>
        </b-input-group>
      </div>
    </div>
    <div id="map">
      <gmap-map
        :center="center"
        :zoom="zoom"
        style="width:100%;  height: 425px;"
      >
        <gmap-info-window
          :options="infoOptions"
          :position="infoWindowPos"
          :opened="infoWinOpen"
          @closeclick="infoWinOpen=false">
          {{infoContent}}
        </gmap-info-window>
        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :clickable="true"
          @click="toggleInfoWindow(m,index)"
        ></gmap-marker>
      </gmap-map>
    </div>
  </div>
</template>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHecluKDprEeKSbk3WkCLHjEUEa6CNXmg"></script>

<script>
export default {
  name: 'searchMap',
  props: ['name'],
  data () {
    return {
      center: {lat: 46.7667, lng: 2.45}, // Bruère-Allichamps centre exact de la France
      zoom: 5,
      infoContent: '',
      infoWindowPos: {
        lat: 0,
        lng: 0
      },
      infoWinOpen: false,
      currentMidx: null,
      // optional: offset infowindow so it visually sits nicely on top of our marker
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      /*tMarker: [{
        position: {
          lat: 43.6109,
          lng: 3.87723
        },
        title: 'Montpellier',
        type: 'concession'
      }, {
        position: {
          lat: 45.767299,
          lng: 4.834329
        },
        title: 'Lyon',
        type: 'concession'
      }, {
        position: {
          lat: 43.297612,
          lng: 5.381042
        },
        title: 'Marseille',
        type: 'concession'
      }, {
        position: {
          lat: 48.856667,
          lng: 2.350987
        },
        title: 'Paris',
        type: 'concession'
      }],*/
      tMarker: [],
      markers: [],
      places: [],
      currentPlace: null,
      text: '',
      titleMarker: [],
      positionMarker: []
    }
  },
  mounted: function(){
    this.getAllMembers();
  },
  methods: {
    // receives a place object via the autocomplete component
    setPlace (place) {
      this.currentPlace = place
    },
    addMarkerSearch () {
      // if(ville dans la barre de recherche && this.currentPlace)
      if (this.currentPlace) {
        this.markers = []
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        }
        this.markers.push({ position: marker })
        this.places.push(this.currentPlace)
        this.center = marker
        this.displayMarkersCarDealer(this.currentPlace.geometry.location.lat(), this.currentPlace.geometry.location.lng(), this.tMarker)
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
      this.markers = []
      this.inputText = this.text
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.zoom = 15
        this.addMarkerGeolocalisation(position.coords.latitude, position.coords.longitude)
        this.displayMarkersCarDealer(position.coords.latitude, position.coords.longitude, this.tMarker)
      })
      if (this.center !== this.marker) {
        this.center = this.markers
        this.zoom = 15
      }
    },
    displayMarkersCarDealer (latitude, longitude, tmarker) {
      // Avec les latitude et longitude récupéré, mettre les markers (qui vont être récupéré dans la bdd) dans un rayon de 10km
      var data
      var i
      var nb = tmarker.length
      for (i = 0; i < nb; i++) {
        data = tmarker[i]
        this.markers.push({ position: data.position })
        this.titleMarker[i] = data.title
        this.positionMarker[i] = data.position
      }
    },
    toggleInfoWindow: function (marker, index) {
      var cpt = 0
      var nb = this.positionMarker.length
      for (var i = 0; i < nb; i++) {
        if (marker.position == this.positionMarker[i]) {
          this.infoContent = this.titleMarker[i]
          cpt = cpt + 1
        }
      }
      if (cpt == 0) {
        this.infoContent = 'Votre position'
      }
      this.center = marker.position
      this.zoom = 16
      this.infoWindowPos = marker.position
      // check if its the same marker that was selected if yes toggle
      if (this.currentMidx == index) {
        this.infoWinOpen = !this.infoWinOpen
      } else { // if different marker set infowindow to open and reset current marker index
        this.infoWinOpen = true
        this.currentMidx = index
      }
      cpt = 0
    },
    getAllMembers: function () {
      axios.get('ajaxfile.php')
      .then(function (response) {
         app.tMarker = response.data
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
