<template>
  <div class="searchMap">
    <div class="icon_map">
      <input type="image" src="http://localhost:81/ProjectCar/Images/searchIcon.png" @click="geolocate" alt="geolocalisation" id="icon" class="icon"/>
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
    <div>
      <gmap-map id="map"
        :center="center"
        :zoom="zoom"
        style="width:100%;  height: 500px;"
      >
        <gmap-info-window
          :options="infoOptions"
          :position="infoWindowPos"
          :opened="infoWinOpen"
          @closeclick="infoWinOpen=false">
          <div v-html="infoContent"></div> <!-- Permet de mettre en html le texte récupéré -->
        </gmap-info-window>
        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :icon.sync="m.icon"
          :clickable="true"
          @click="toggleInfoWindow(m,index)"
        ></gmap-marker>
      </gmap-map>
    </div>
  </div>
</template>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHecluKDprEeKSbk3WkCLHjEUEa6CNXmg"></script>
<script src="//maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>

<script>
export default {
  name: 'searchMap',
  props: ['name'],
  data () {
    return {
      center: { lat: 46.7667, lng: 2.45 }, // Bruère-Allichamps centre exact de la France
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
      tMarker: [],
      markers: [],
      places: [],
      currentPlace: null,
      text: '',
      infoMarker: [],
      positionMarker: []
    }
  },
  mounted: function(){
    this.getAllConcession()
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
      var image = 'http://localhost:81/ProjectCar/Images/greenMarker.png'
      const marker = {
        lat: latitude,
        lng: longitude
      }
      this.markers.push({ position: marker, icon: image })
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
        this.zoom = 13
        this.addMarkerGeolocalisation(position.coords.latitude, position.coords.longitude)
        this.displayMarkersCarDealer(position.coords.latitude, position.coords.longitude, this.tMarker)
      })
    },
    displayMarkersCarDealer (latitude, longitude, tmarker) {
      var data, i, j
      var nbMarker = tmarker.length
      for (i = 0; i < nbMarker; i++) {
        data = tmarker[i]
        var contentHtml = '<div id="bodyContent">' +
          '<h6><center><a href="http://localhost:8080/concession/' + data.raisonSociale + '">' + data.raisonSociale + '</a><center></h6>' +
          '<div id="bodyContent">' +
          data.adresse +
          '</br>' + data.codePostal + ' ' + data.ville +
          '</br>' + data.pays +
          '</br><b><a href="' + data.siteWeb + '">Site web</a><b>' +
          '</div></div>'
        this.infoMarker[i] = contentHtml
        this.positionMarker[i] = { lat: parseFloat(data.latitude), lng: parseFloat(data.longitude) }
      }
      var nbPosition = this.positionMarker.length
      for (j = 0; j < nbPosition; j++) {
        var data = this.positionMarker[j]
        var rad = function(x) {
          return x * Math.PI / 180;
        }
        var getDistance = function({lat: latitude, lng: longitude}, data) {
          var R = 6378137; // Earth’s mean radius in meter
          this.dLat = rad(data.lat() - {lat: latitude, lng: longitude}.lat());
          var dLong = rad(data.lng() - {lat: latitude, lng: longitude}.lng());
          var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(rad({lat: latitude, lng: longitude}.lat())) * Math.cos(rad(data.lat())) *
            Math.sin(dLong / 2) * Math.sin(dLong / 2);
          var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
          vard = R * c;
          return d; // returns the distance in meter
        };
        // if
        console.log(data)
        this.markers.push({ position: this.positionMarker[j] }) // Affiche les markers
      }
    },
    toggleInfoWindow: function (marker, index) {
      var cpt = 0
      var nb = this.positionMarker.length
      for (var i = 0; i < nb; i++) {
        if (marker.position == this.positionMarker[i]) {
          this.infoContent = this.infoMarker[i]
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
    getAllConcession: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/ajaxfile.php') // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer toutes les concessions
      .then(function (response) {
         this.tMarker = response.data
         console.log(this.tMarker)
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
