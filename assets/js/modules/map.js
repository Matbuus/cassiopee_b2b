import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default class Map {
	
	static init () {
		let map = document.querySelector('#map')
		if(map === null){
			return
		}
		let icon = L.icon({
		    iconUrl:'/images/marker-icon.png',
		})
		let center = [map.dataset.lat, map.dataset.lng]
		map = L.map('map').setView(center, 15 )
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 20,
			minZoom: 10,
		    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);

		L.marker(center, {icon: icon}).addTo(map)
	}
}