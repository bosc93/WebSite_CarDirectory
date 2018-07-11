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
      <gmap-map
        :center="center"
        :zoom="zoom"
        style="width:100%;  height: 500px;"
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
          :icon.sync="m.icon"
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
      // Avec les latitudes et longitudes récupérées, mettre les markers (qui vont être récupéré dans la bdd) dans un rayon de 10km
      var data
      var i
      var nb = tmarker.length
      for (i = 0; i < nb; i++) {
        data = tmarker[i]
        this.positionMarker[i] = { lat: parseFloat(data.latitude), lng: parseFloat(data.longitude) }
        var contentHtml = document.createElement('div')
        contentHtml.innerHTML = '<html><head><title>' + data.raisonSociale + '</title></head><body>' + '<h1>'+ data.raisonSociale + '</h1>' +
            '</br>'+
            '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
            'sandstone rock formation in the southern part of the '+
            'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
            'south west of the nearest large town, Alice Springs; 450&#160;km '+
            '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
            'features of the Uluru - Kata Tjuta National Park. Uluru is '+
            'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
            'Aboriginal people of the area. It has many springs, waterholes, '+
            'rock caves and ancient paintings. Uluru is listed as a World '+
            'Heritage Site.</p>'+
            '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
            'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
            '(last visited June 22, 2009).</p>' +
            '</body>' +
            '</html>'
        this.infoMarker[i] = contentHtml
        console.log(contentHtml)
        this.markers.push({ position: this.positionMarker[i] }) // Affiche les markers
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
