<template>
  <div class="general"> <!-- En haut : notes, a gauche : horaires, au milieu : marques et modeles de voiture, a droite : map -->
    <div class="resumeNote">
      <img class="icon_note" src="../../assets/icon_note.png" alt="note">
      {{ note }}
    </div>
    <div>
      <b-container class="bv-example-row">
        <b-row class="justify-content-md-center">
          <b-col id="schedules" cols="12" md="auto"> <!-- Liste d'horaires -->
            <div>Horaires</div>
            <ul class="list-group" v-for="(timetable, index) in timeTables" :key="index">
              <li class="list-group-item">{{ timetable.jour + ' : ' + timetable.heureDebut + ' - ' + timetable.heureFin }}</li>
            </ul>
          </b-col>
          <b-col id="brandCar" col lg="0" md="auto"> <!-- Liste de marques et de modeles de voiture existantes dans la concession -->
            <div>Marques disponibles</div>
            <ul class="list-group" v-for="(carMark, index) in carMarks" :key="index">
              <li class="list-group-item" @mouseover="hoverCarModel(carMark.marque)"><a href="">{{ carMark.marque }}</a></li>
            </ul>
          </b-col>
          <b-modal size="lg" ref="myModalRef" hide-footer v-bind:title="titleMark" @mouseout="hideCarModel"> <!-- Popup avec la liste de modeles disponibles dans la concession pour la marque de voiture sélectionnée sous forme de carrousel -->
            <carousel :perPage="4" paginationColor="#000000" paginationActiveColor="#6c58bF" :navigationEnabled="true">
              <slide
                  class="carousel-item col-md-4 active"
                  v-for="(car, index) in cars" :key="index"
                  v-if="car.marque==mark">
                  <div class="card">
                    <img class="card-img-top img-fluid" :src="'http://localhost:81/ProjectCar/Images/Car/' + mark + '_' + car.modele + '.png'" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-title">{{ car.modele }}</p>
                    </div>
                  </div>
              </slide>
            </carousel>
          </b-modal>
          <b-col id="map" col lg="0"> <!-- Map avec lieu de la concession -->
            <gmap-map
              :center="center"
              :zoom="zoom"
              :options="{
                scrollwheel: true,
                disableDefaultUI: true,
                fullscreenControl: true
              }"
              style="width:100%;  height:300px;"
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
                v-for="(m, index) in markerConcession"
                :position="m.position"
                :icon.sync="m.icon"
                :clickable="true"
                @click="toggleInfoWindow(m,index)"
              ></gmap-marker>
            </gmap-map>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel'

export default {
  name: 'DetailsOperation',
  components: {
    Carousel,
    Slide
  },
  data () {
    return {
      idConcession: this.$route.params.id,
      timeTables: [],
      concession: [],
      cars: [],
      carMarks: [],
      titleMark: '',
      mark: '',
      note: '***', // En faire une table d'avis et de notation reliée à l'idConcession de la table concession
      center: { lat: 46.7667, lng: 2.45 },
      zoom: 16,
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
      markerConcession: []
    }
  },
  mounted: function () {
    this.getConcession()
    this.getTimeTable()
    this.getCarMarks()
    this.getCarModels()
  },
  methods: {
    hoverCarModel: function (mark) {
      this.mark = mark
      this.titleMark = 'Modèles de ' + mark + ' disponibles'
      this.$refs.myModalRef.show()
    },
    hideCarModel () {
      this.$refs.myModalRef.hide()
    },
    addMarkerGeolocalisation: function () {
      // 43.6350288
      // 3.8356061
      var latitude = parseFloat(this.concession[0].latitude)
      var longitude = parseFloat(this.concession[0].longitude)
      var image = 'http://localhost:81/ProjectCar/Images/greenMarker.png'
      const marker = {
        lat: latitude,
        lng: longitude
      }
      this.markerConcession.push({ position: marker, icon: image })
      this.center = marker
    },
    toggleInfoWindow: function (marker, index) {
      var data
      console.log(this.concession[0])
      data = this.concession[0]
      var contentHtml = '<div id="bodyContent">' +
        '<h6><center>' + data.raisonSociale + '</a><center></h6>' +
        '<div id="bodyContent">' +
        data.adresse +
        '</br>' + data.codePostal + ' ' + data.ville +
        '</br>' + data.pays +
        '</br><b><a href="' + data.siteWeb + '">Site web</a><b>' +
        '</div></div>'
      this.infoContent = contentHtml
      this.center = marker.position
      this.infoWindowPos = marker.position
      // check if its the same marker that was selected if yes toggle
      if (this.currentMidx === index) {
        this.infoWinOpen = !this.infoWinOpen
      } else { // if different marker set infowindow to open and reset current marker index
        this.infoWinOpen = true
        this.currentMidx = index
      }
    },
    getConcession: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_concession&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer la concession par id
        .then(function (response) {
          this.concession = response.data
          console.log(this.concession)
          this.addMarkerGeolocalisation()
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    getTimeTable: function () {
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_timeTable&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer les jour et horaires par concession
        .then(function (response) {
          this.timeTables = response.data
          console.log(this.timeTables)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    getCarMarks: function () { // Faire une table de voiture et leur relier l'idConcession de la table concession
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_carMark&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer les marques de voiture par concession
        .then(function (response) {
          this.carMarks = response.data
          console.log(this.carMarks)
        })
        .catch(function (error) {
          console.log(error)
        })
    },
    getCarModels: function () { // Faire une table de voiture et leur relier l'idConcession de la table concession
      this.$http.get('http://localhost:81/ProjectCar/Api_ProjectCar/api.php?action=get_car&id=' + this.idConcession) // Pointe sur l'api dans le localhost du wamp (ajaxfile.php) pour récupérer les modeles de voiture par concession
        .then(function (response) {
          this.cars = response.data
          console.log(this.cars)
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
.resumeNote {
  background-color: aquamarine;
}
</style>
