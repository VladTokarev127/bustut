

	<?php wp_footer(); ?>
	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
	<script>
		Vue.createApp({
			data: () => ({
				search: '',
				loading: true,
				url: 'https://bus.tutu.ru/bus/v1/schedule/bus_terminal/?bus_stop_id=1177120&offset=0&limit=100',
				departure: 1444796,
				stations: [],
				stationsNames: {},
				data: [],
				dataStations: []
			}),
			mounted () {
				fetch(this.url)
					.then(res => res.text())
					.then((res) => {
						this.data = JSON.parse(res).data;
						let obj;
						this.data.forEach(item => {
							this.dataStations.push(item.geoPointId);
							obj = {
								arrival: ''+item.geoPointId,
								schedules: []
							};
							item.schedules.forEach(schedule => {
								let someObj = {
									time: schedule.time,
									days: schedule.activeDaysData.mode,
									transit: schedule.isTransit,
									activeDays: schedule.activeDaysData.params.activeDays ? schedule.activeDaysData.params.activeDays : schedule.activeDays
								};
								obj.schedules.push(someObj)
							})
							this.stations.push(obj)
						});

						this.dataStationUnic.forEach(item => {
							let geoUrl = `https://api-bus.tutu.ru/v1/search/?departureId=${this.departure}&arrivalId=${item}&departureDate=09.02.2023&seatCount=1`
							fetch(geoUrl)
								.then(res => res.text())
								.then((res) => {
									this.stationsNames[item] = JSON.parse(res).data.references.geoPoints[1].name;
								})
						});

						this.init();
					})
			},
			computed: {
				dataStationUnic() {
					let result = [];

					result = this.dataStations.reduce((acc, item) => {
						if (acc.includes(item)) {
							return acc;
						}
						return [...acc, item];
					}, [])

					return result;
				}
			},
			methods: {
				searchFun: (e) => {
					let target = e.target;
					let val = target.value;
					let $delay = 500;
					clearTimeout(target.dataset.timer);
					target.dataset.timer = setTimeout(() => {
						target.dataset.timer = '';
						let items = document.querySelectorAll('.station__item');
						items.forEach((item) => {
							item.style.display = 'flex';
							let text = item.querySelector('.station__item-title span').textContent
							console.log(val);
							console.log(text);
							console.log(text.indexOf(val));
							if (text.indexOf(val) != -1) {
								item.style.display = 'flex';
							} else {
								item.style.display = 'none';
							}
						})
					}, $delay)
				},
				init: function() {

				}
			}
		}).mount('#app');
	</script>

</body>
</html>